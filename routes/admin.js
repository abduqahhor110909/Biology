const express = require('express');
const router = express.Router();
const bcrypt = require('bcryptjs');
const db = require('../db');
const upload = require('../utils/uploader');
const { requireAuth } = require('../middleware/auth');
const { formatDate, slugify } = require('../utils/helpers');

// Helper for pagination
function getPagination(total, page, perPage, baseUrl, queryStr = '') {
    const totalPages = Math.ceil(total / perPage) || 1;
    const currentPage = Math.max(1, Math.min(page, totalPages));
    return {
        total,
        totalPages,
        currentPage,
        perPage,
        baseUrl,
        queryStr
    };
}

/*
|--------------------------------------------------------------------------
| Admin Auth Routes (Public)
|--------------------------------------------------------------------------
*/
router.get('/login', (req, res) => {
    if (req.session.userId) {
        return res.redirect('/admin/dashboard');
    }
    res.render('admin/login', {
        layout: false,
        error: req.flash('error'),
        info: req.flash('info')
    });
});

router.post('/login', (req, res) => {
    const { email, password } = req.body;

    if (!email || !password) {
        req.flash('error', 'Iltimos, email va parolni to\'liq kiriting.');
        return res.redirect('/admin/login');
    }

    const user = db.get('SELECT * FROM users WHERE email = ?', [email.trim()]);
    if (!user) {
        req.flash('error', 'Kiritilgan email yoki parol noto\'g\'ri.');
        return res.redirect('/admin/login');
    }

    const isMatch = bcrypt.compareSync(password, user.password);
    if (!isMatch) {
        req.flash('error', 'Kiritilgan email yoki parol noto\'g\'ri.');
        return res.redirect('/admin/login');
    }

    req.session.userId = user.id;
    req.flash('success', 'Xush kelibsiz, Admin!');
    res.redirect('/admin/dashboard');
});

router.all('/logout', (req, res) => {
    req.session.destroy(() => {
        res.redirect('/admin/login');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
router.use(requireAuth);

// 1. Dashboard
router.get(['/', '/dashboard'], (req, res) => {
    const articlesCount = db.get('SELECT COUNT(*) AS c FROM articles').c;
    const bannersCount = db.get('SELECT COUNT(*) AS c FROM banners WHERE is_active = 1').c;
    const webinarsCount = db.get('SELECT COUNT(*) AS c FROM webinars').c;
    const inquiriesCount = db.get('SELECT COUNT(*) AS c FROM inquiries').c;
    const newInquiries = db.get("SELECT COUNT(*) AS c FROM inquiries WHERE status = 'new'").c;
    const totalViews = db.get('SELECT SUM(views_count) AS s FROM articles').s || 0;

    const stats = {
        articles_count: articlesCount,
        banners_count: bannersCount,
        webinars_count: webinarsCount,
        inquiries_count: inquiriesCount,
        new_inquiries: newInquiries,
        total_views: totalViews
    };

    const recentInquiries = db.all('SELECT * FROM inquiries ORDER BY id DESC LIMIT 6');
    const recentArticles = db.all(`
        SELECT a.*, c.name AS category_name 
        FROM articles a 
        LEFT JOIN categories c ON a.category_id = c.id 
        ORDER BY a.id DESC 
        LIMIT 5
    `);
    const activeBanners = db.all('SELECT * FROM banners ORDER BY id DESC LIMIT 4');

    res.render('admin/dashboard', {
        layout: 'layouts/admin',
        title: 'Boshqaruv Paneli',
        currentPath: '/admin/dashboard',
        stats,
        recentInquiries,
        recentArticles,
        activeBanners,
        formatDate
    });
});

// 2. Settings
router.get('/settings', (req, res) => {
    const settings = db.getAllSettings();
    res.render('admin/settings', {
        layout: 'layouts/admin',
        title: 'Sayt Sozlamalari, Linklar va Dizayn',
        currentPath: '/admin/settings',
        settings
    });
});

router.post('/settings', upload.single('hero_image_file'), (req, res) => {
    const data = { ...req.body };

    if (req.file) {
        data.hero_image = `/images/${req.file.filename}`;
    }

    for (const [key, val] of Object.entries(data)) {
        if (key !== '_token' && key !== 'hero_image_file') {
            db.updateSetting(key, val);
        }
    }

    req.flash('success', 'Sayt sozlamalari, ijtimoiy tarmoq linklari va dizayn parametrlari muvaffaqiyatli saqlandi!');
    res.redirect('/admin/settings');
});

// 3. Banners
router.get('/banners', (req, res) => {
    const page = parseInt(req.query.page, 10) || 1;
    const perPage = 10;
    const offset = (page - 1) * perPage;

    const total = db.get('SELECT COUNT(*) AS c FROM banners').c;
    const banners = db.all('SELECT * FROM banners ORDER BY sort_order ASC, id DESC LIMIT ? OFFSET ?', [perPage, offset]);
    const pagination = getPagination(total, page, perPage, '/admin/banners');

    res.render('admin/banners/index', {
        layout: 'layouts/admin',
        title: 'Reklama va Bannerlar Boshqaruvi',
        currentPath: '/admin/banners',
        banners,
        pagination
    });
});

router.get('/banners/create', (req, res) => {
    res.render('admin/banners/create', {
        layout: 'layouts/admin',
        title: 'Yangi Reklama / Banner Qo\'shish',
        currentPath: '/admin/banners'
    });
});

router.post('/banners', upload.single('image_file'), (req, res) => {
    const { title, badge, description, button_text, button_url, position, bg_gradient, sort_order, image_url } = req.body;
    const is_active = req.body.is_active ? 1 : 0;
    let image = '/images/promo-banner.jpg';

    if (req.file) {
        image = `/images/${req.file.filename}`;
    } else if (image_url && image_url.trim()) {
        image = image_url.trim();
    }

    const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
    db.run(`
        INSERT INTO banners (title, badge, description, button_text, button_url, image, position, bg_gradient, is_active, sort_order, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    `, [title, badge || null, description || null, button_text || 'Batafsil', button_url || '#', image, position || 'middle_feed', bg_gradient || 'from-emerald-600 to-teal-800', is_active, parseInt(sort_order, 10) || 0, now, now]);

    req.flash('success', 'Reklama banneri muvaffaqiyatli qo\'shildi!');
    res.redirect('/admin/banners');
});

router.get('/banners/:id/edit', (req, res) => {
    const banner = db.get('SELECT * FROM banners WHERE id = ?', [req.params.id]);
    if (!banner) {
        req.flash('error', 'Banner topilmadi.');
        return res.redirect('/admin/banners');
    }

    res.render('admin/banners/edit', {
        layout: 'layouts/admin',
        title: 'Reklama Bannerini Tahrirlash',
        currentPath: '/admin/banners',
        banner
    });
});

router.post('/banners/:id', upload.single('image_file'), (req, res) => {
    const { id } = req.params;
    const banner = db.get('SELECT * FROM banners WHERE id = ?', [id]);
    if (!banner) {
        req.flash('error', 'Banner topilmadi.');
        return res.redirect('/admin/banners');
    }

    const { title, badge, description, button_text, button_url, position, bg_gradient, sort_order, image_url } = req.body;
    const is_active = req.body.is_active ? 1 : 0;
    let image = banner.image;

    if (req.file) {
        image = `/images/${req.file.filename}`;
    } else if (image_url && image_url.trim()) {
        image = image_url.trim();
    }

    const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
    db.run(`
        UPDATE banners 
        SET title = ?, badge = ?, description = ?, button_text = ?, button_url = ?, image = ?, position = ?, bg_gradient = ?, is_active = ?, sort_order = ?, updated_at = ?
        WHERE id = ?
    `, [title, badge || null, description || null, button_text, button_url, image, position, bg_gradient || banner.bg_gradient, is_active, parseInt(sort_order, 10) || 0, now, id]);

    req.flash('success', 'Reklama banneri yangilandi!');
    res.redirect('/admin/banners');
});

router.post('/banners/:id/toggle', (req, res) => {
    const banner = db.get('SELECT id, is_active FROM banners WHERE id = ?', [req.params.id]);
    if (banner) {
        const nextState = banner.is_active ? 0 : 1;
        db.run('UPDATE banners SET is_active = ? WHERE id = ?', [nextState, banner.id]);
        req.flash('success', 'Banner holati o\'zgartirildi.');
    }
    res.redirect('back');
});

router.post('/banners/:id/delete', (req, res) => {
    db.run('DELETE FROM banners WHERE id = ?', [req.params.id]);
    req.flash('success', 'Banner o\'chirildi.');
    res.redirect('/admin/banners');
});

// 4. Articles
router.get('/articles', (req, res) => {
    const page = parseInt(req.query.page, 10) || 1;
    const perPage = 10;
    const offset = (page - 1) * perPage;

    const total = db.get('SELECT COUNT(*) AS c FROM articles').c;
    const articles = db.all(`
        SELECT a.*, c.name AS category_name 
        FROM articles a 
        LEFT JOIN categories c ON a.category_id = c.id 
        ORDER BY a.id DESC 
        LIMIT ? OFFSET ?
    `, [perPage, offset]);
    const pagination = getPagination(total, page, perPage, '/admin/articles');

    res.render('admin/articles/index', {
        layout: 'layouts/admin',
        title: 'Biologiya Maqolalari Boshqaruvi',
        currentPath: '/admin/articles',
        articles,
        pagination
    });
});

router.get('/articles/create', (req, res) => {
    const categories = db.all('SELECT * FROM categories ORDER BY name ASC');
    res.render('admin/articles/create', {
        layout: 'layouts/admin',
        title: 'Yangi Maqola Yozish',
        currentPath: '/admin/articles',
        categories
    });
});

router.post('/articles', upload.single('image_file'), (req, res) => {
    const { title, category_id, excerpt, content, read_time, image_url } = req.body;
    const is_featured = req.body.is_featured ? 1 : 0;
    const is_published = req.body.is_published ? 1 : 0;
    const slug = slugify(title) + '-' + Math.floor(100 + Math.random() * 900);

    let image = '/images/hero-banner.jpg';
    if (req.file) {
        image = `/images/${req.file.filename}`;
    } else if (image_url && image_url.trim()) {
        image = image_url.trim();
    }

    const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
    db.run(`
        INSERT INTO articles (title, slug, category_id, excerpt, content, image, read_time, views_count, is_featured, is_published, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?, ?)
    `, [title, slug, category_id || null, excerpt || null, content, image, read_time || '5 daqiqa', is_featured, is_published, now, now]);

    req.flash('success', 'Biologiya maqolasi muvaffaqiyatli saqlandi!');
    res.redirect('/admin/articles');
});

router.get('/articles/:id/edit', (req, res) => {
    const article = db.get('SELECT * FROM articles WHERE id = ?', [req.params.id]);
    if (!article) {
        req.flash('error', 'Maqola topilmadi.');
        return res.redirect('/admin/articles');
    }
    const categories = db.all('SELECT * FROM categories ORDER BY name ASC');

    res.render('admin/articles/edit', {
        layout: 'layouts/admin',
        title: 'Maqolani Tahrirlash',
        currentPath: '/admin/articles',
        article,
        categories
    });
});

router.post('/articles/:id', upload.single('image_file'), (req, res) => {
    const { id } = req.params;
    const article = db.get('SELECT * FROM articles WHERE id = ?', [id]);
    if (!article) {
        req.flash('error', 'Maqola topilmadi.');
        return res.redirect('/admin/articles');
    }

    const { title, category_id, excerpt, content, read_time, image_url } = req.body;
    const is_featured = req.body.is_featured ? 1 : 0;
    const is_published = req.body.is_published ? 1 : 0;

    let image = article.image;
    if (req.file) {
        image = `/images/${req.file.filename}`;
    } else if (image_url && image_url.trim()) {
        image = image_url.trim();
    }

    const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
    db.run(`
        UPDATE articles 
        SET title = ?, category_id = ?, excerpt = ?, content = ?, image = ?, read_time = ?, is_featured = ?, is_published = ?, updated_at = ?
        WHERE id = ?
    `, [title, category_id || null, excerpt || null, content, image, read_time || article.read_time, is_featured, is_published, now, id]);

    req.flash('success', 'Maqola muvaffaqiyatli yangilandi!');
    res.redirect('/admin/articles');
});

router.post('/articles/:id/delete', (req, res) => {
    db.run('DELETE FROM articles WHERE id = ?', [req.params.id]);
    req.flash('success', 'Maqola o\'chirildi.');
    res.redirect('/admin/articles');
});

// 5. Webinars
router.get('/webinars', (req, res) => {
    const page = parseInt(req.query.page, 10) || 1;
    const perPage = 10;
    const offset = (page - 1) * perPage;

    const total = db.get('SELECT COUNT(*) AS c FROM webinars').c;
    const webinars = db.all('SELECT * FROM webinars ORDER BY sort_order ASC, id DESC LIMIT ? OFFSET ?', [perPage, offset]);
    const pagination = getPagination(total, page, perPage, '/admin/webinars');

    res.render('admin/webinars/index', {
        layout: 'layouts/admin',
        title: 'Vebinarlar va Darslar Boshqaruvi',
        currentPath: '/admin/webinars',
        webinars,
        pagination
    });
});

router.get('/webinars/create', (req, res) => {
    res.render('admin/webinars/create', {
        layout: 'layouts/admin',
        title: 'Yangi Vebinar Qo\'shish',
        currentPath: '/admin/webinars'
    });
});

router.post('/webinars', upload.single('image_file'), (req, res) => {
    const { title, badge, instructor_name, instructor_title, date_time_text, duration, price_text, description, join_link, image_url, sort_order } = req.body;
    const is_free = req.body.is_free ? 1 : 0;
    const is_active = req.body.is_active ? 1 : 0;

    let image = '/images/promo-banner.jpg';
    if (req.file) {
        image = `/images/${req.file.filename}`;
    } else if (image_url && image_url.trim()) {
        image = image_url.trim();
    }

    const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
    db.run(`
        INSERT INTO webinars (title, badge, instructor_name, instructor_title, date_time_text, duration, is_free, price_text, description, join_link, image, is_active, sort_order, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    `, [title, badge || 'Vebinar', instructor_name, instructor_title || null, date_time_text, duration || '90 daqiqa', is_free, price_text || null, description || null, join_link || null, image, is_active, parseInt(sort_order, 10) || 0, now, now]);

    req.flash('success', 'Vebinar muvaffaqiyatli qo\'shildi!');
    res.redirect('/admin/webinars');
});

router.get('/webinars/:id/edit', (req, res) => {
    const webinar = db.get('SELECT * FROM webinars WHERE id = ?', [req.params.id]);
    if (!webinar) {
        req.flash('error', 'Vebinar topilmadi.');
        return res.redirect('/admin/webinars');
    }

    res.render('admin/webinars/edit', {
        layout: 'layouts/admin',
        title: 'Vebinarni Tahrirlash',
        currentPath: '/admin/webinars',
        webinar
    });
});

router.post('/webinars/:id', upload.single('image_file'), (req, res) => {
    const { id } = req.params;
    const webinar = db.get('SELECT * FROM webinars WHERE id = ?', [id]);
    if (!webinar) {
        req.flash('error', 'Vebinar topilmadi.');
        return res.redirect('/admin/webinars');
    }

    const { title, badge, instructor_name, instructor_title, date_time_text, duration, price_text, description, join_link, image_url, sort_order } = req.body;
    const is_free = req.body.is_free ? 1 : 0;
    const is_active = req.body.is_active ? 1 : 0;

    let image = webinar.image;
    if (req.file) {
        image = `/images/${req.file.filename}`;
    } else if (image_url && image_url.trim()) {
        image = image_url.trim();
    }

    const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
    db.run(`
        UPDATE webinars 
        SET title = ?, badge = ?, instructor_name = ?, instructor_title = ?, date_time_text = ?, duration = ?, is_free = ?, price_text = ?, description = ?, join_link = ?, image = ?, is_active = ?, sort_order = ?, updated_at = ?
        WHERE id = ?
    `, [title, badge || webinar.badge, instructor_name, instructor_title || null, date_time_text, duration || webinar.duration, is_free, price_text || null, description || null, join_link || null, image, is_active, parseInt(sort_order, 10) || 0, now, id]);

    req.flash('success', 'Vebinar muvaffaqiyatli yangilandi!');
    res.redirect('/admin/webinars');
});

router.post('/webinars/:id/delete', (req, res) => {
    db.run('DELETE FROM webinars WHERE id = ?', [req.params.id]);
    req.flash('success', 'Vebinar o\'chirildi.');
    res.redirect('/admin/webinars');
});

// 6. Stats counters
router.get('/stats', (req, res) => {
    const stats = db.all('SELECT * FROM stats_counters ORDER BY sort_order ASC');
    res.render('admin/stats/index', {
        layout: 'layouts/admin',
        title: 'Statistika Hisoblagichlari',
        currentPath: '/admin/stats',
        stats
    });
});

router.post('/stats', (req, res) => {
    const { counters } = req.body;
    if (counters && typeof counters === 'object') {
        const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
        for (const [id, item] of Object.entries(counters)) {
            db.run(`
                UPDATE stats_counters 
                SET number = ?, suffix = ?, label = ?, updated_at = ?
                WHERE id = ?
            `, [item.number, item.suffix || '+', item.label, now, id]);
        }
    }

    req.flash('success', 'Statistika hisoblagichlari muvaffaqiyatli yangilandi!');
    res.redirect('/admin/stats');
});

// 7. Inquiries
router.get('/inquiries', (req, res) => {
    const status = req.query.status;
    const page = parseInt(req.query.page, 10) || 1;
    const perPage = 15;
    const offset = (page - 1) * perPage;

    let querySql = 'SELECT * FROM inquiries';
    let countSql = 'SELECT COUNT(*) AS c FROM inquiries';
    const params = [];

    if (status && ['new', 'contacted', 'completed'].includes(status)) {
        querySql += ' WHERE status = ?';
        countSql += ' WHERE status = ?';
        params.push(status);
    }

    querySql += ' ORDER BY id DESC LIMIT ? OFFSET ?';
    const total = db.get(countSql, params).c;
    const inquiries = db.all(querySql, [...params, perPage, offset]);

    const counts = {
        all: db.get('SELECT COUNT(*) AS c FROM inquiries').c,
        new: db.get("SELECT COUNT(*) AS c FROM inquiries WHERE status = 'new'").c,
        contacted: db.get("SELECT COUNT(*) AS c FROM inquiries WHERE status = 'contacted'").c,
        completed: db.get("SELECT COUNT(*) AS c FROM inquiries WHERE status = 'completed'").c
    };

    const pagination = getPagination(total, page, perPage, '/admin/inquiries', status ? `status=${status}` : '');

    res.render('admin/inquiries/index', {
        layout: 'layouts/admin',
        title: 'Kelib Tushgan Arizalar va Murojaatlar',
        currentPath: '/admin/inquiries',
        inquiries,
        counts,
        status,
        pagination,
        formatDate
    });
});

router.post('/inquiries/:id/status', (req, res) => {
    const { id } = req.params;
    const { status } = req.body;
    if (['new', 'contacted', 'completed'].includes(status)) {
        const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
        db.run('UPDATE inquiries SET status = ?, updated_at = ? WHERE id = ?', [status, now, id]);
        req.flash('success', 'Ariza holati yangilandi.');
    }
    res.redirect('back');
});

router.post('/inquiries/:id/delete', (req, res) => {
    db.run('DELETE FROM inquiries WHERE id = ?', [req.params.id]);
    req.flash('success', 'Ariza o\'chirildi.');
    res.redirect('back');
});

module.exports = router;
