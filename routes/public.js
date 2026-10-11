const express = require('express');
const router = express.Router();
const db = require('../db');
const { formatDate } = require('../utils/helpers');

// 1. Home Page
router.get('/', (req, res) => {
    const settings = db.getAllSettings();
    const stats = db.all('SELECT * FROM stats_counters ORDER BY sort_order ASC');
    const categories = db.all(`
        SELECT c.*, (SELECT COUNT(*) FROM articles a WHERE a.category_id = c.id AND a.is_published = 1) AS articles_count 
        FROM categories c 
        ORDER BY c.sort_order ASC
    `);
    const articles = db.all(`
        SELECT a.*, c.name AS category_name 
        FROM articles a 
        LEFT JOIN categories c ON a.category_id = c.id 
        WHERE a.is_published = 1 
        ORDER BY a.is_featured DESC, a.id DESC 
        LIMIT 6
    `);
    const webinars = db.all('SELECT * FROM webinars WHERE is_active = 1 ORDER BY sort_order ASC');
    const heroBanner = db.get('SELECT * FROM banners WHERE position = ? AND is_active = 1 LIMIT 1', ['hero_bottom']);
    const middleBanner = db.get('SELECT * FROM banners WHERE position = ? AND is_active = 1 LIMIT 1', ['middle_feed']);
    const allBanners = db.all('SELECT * FROM banners WHERE is_active = 1 ORDER BY sort_order ASC');
    const quizzes = db.all('SELECT * FROM quiz_questions ORDER BY RANDOM() LIMIT 5');

    res.render('home', {
        layout: 'layouts/app',
        settings,
        stats,
        categories,
        articles,
        webinars,
        heroBanner,
        middleBanner,
        allBanners,
        quizzes,
        formatDate
    });
});

// 2. Article Detail Page
router.get('/maqola/:slug', (req, res) => {
    const { slug } = req.params;
    const settings = db.getAllSettings();

    const article = db.get(`
        SELECT a.*, c.name AS category_name 
        FROM articles a 
        LEFT JOIN categories c ON a.category_id = c.id 
        WHERE a.slug = ?
    `, [slug]);

    if (!article) {
        return res.status(404).render('404', {
            layout: 'layouts/app',
            settings,
            message: 'Kechirasiz, so\'ralgan maqola topilmadi.'
        });
    }

    // Increment views count
    db.run('UPDATE articles SET views_count = views_count + 1 WHERE id = ?', [article.id]);
    article.views_count = (article.views_count || 0) + 1;

    // Related articles
    const relatedArticles = db.all(`
        SELECT * FROM articles 
        WHERE category_id = ? AND id != ? AND is_published = 1 
        ORDER BY id DESC 
        LIMIT 3
    `, [article.category_id, article.id]);

    const protocol = req.protocol;
    const host = req.get('host');
    const currentUrl = `${protocol}://${host}${req.originalUrl}`;

    res.render('article', {
        layout: 'layouts/app',
        settings,
        article,
        relatedArticles,
        currentUrl,
        formatDate
    });
});

// 3. Inquiry submission (Lead registration)
router.post('/ariza-yuborish', (req, res) => {
    const { name, phone, interest, message } = req.body;
    const isJson = req.xhr || (req.headers.accept && req.headers.accept.includes('application/json')) || req.headers['x-requested-with'] === 'XMLHttpRequest';

    if (!name || !phone) {
        if (isJson) {
            return res.status(422).json({ success: false, message: 'Iltimos, ism va telefon raqamingizni kiriting.' });
        }
        req.flash('error', 'Iltimos, ism va telefon raqamingizni kiriting.');
        return res.redirect('back');
    }

    const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
    db.run(`
        INSERT INTO inquiries (name, phone, interest, message, status, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    `, [name.trim(), phone.trim(), interest ? interest.trim() : null, message ? message.trim() : null, 'new', now, now]);

    const successMsg = 'Arizangiz muvaffaqiyatli qabul qilindi! Tez orada mutaxassisimiz siz bilan bog\'lanadi.';

    if (isJson) {
        return res.json({ success: true, message: successMsg });
    }

    req.flash('success', successMsg);
    res.redirect('/#register');
});

module.exports = router;
