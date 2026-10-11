const bcrypt = require('bcryptjs');
const db = require('./db');

function seedDatabase() {
    console.log('Seeding BioSfera database in Node.js...');

    // 1. Create tables if not exists
    db.db.exec(`
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            email_verified_at TEXT,
            password TEXT NOT NULL,
            remember_token TEXT,
            created_at TEXT,
            updated_at TEXT
        );

        CREATE TABLE IF NOT EXISTS site_settings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            key TEXT UNIQUE NOT NULL,
            value TEXT,
            "group" TEXT DEFAULT 'general',
            created_at TEXT,
            updated_at TEXT
        );

        CREATE TABLE IF NOT EXISTS banners (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            badge TEXT,
            description TEXT,
            button_text TEXT DEFAULT 'Batafsil',
            button_url TEXT DEFAULT '#',
            image TEXT,
            position TEXT DEFAULT 'middle_feed',
            bg_gradient TEXT DEFAULT 'from-emerald-600 to-teal-800',
            is_active INTEGER DEFAULT 1,
            sort_order INTEGER DEFAULT 0,
            created_at TEXT,
            updated_at TEXT
        );

        CREATE TABLE IF NOT EXISTS categories (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT UNIQUE NOT NULL,
            icon TEXT DEFAULT 'bi-dna',
            description TEXT,
            color TEXT DEFAULT 'emerald',
            sort_order INTEGER DEFAULT 0,
            created_at TEXT,
            updated_at TEXT
        );

        CREATE TABLE IF NOT EXISTS articles (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            category_id INTEGER REFERENCES categories(id) ON DELETE SET NULL,
            title TEXT NOT NULL,
            slug TEXT UNIQUE NOT NULL,
            excerpt TEXT,
            content TEXT NOT NULL,
            image TEXT,
            read_time TEXT DEFAULT '5 daqiqa',
            views_count INTEGER DEFAULT 0,
            is_featured INTEGER DEFAULT 0,
            is_published INTEGER DEFAULT 1,
            created_at TEXT,
            updated_at TEXT
        );

        CREATE TABLE IF NOT EXISTS webinars (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            badge TEXT DEFAULT 'Jonli efir',
            instructor_name TEXT NOT NULL,
            instructor_title TEXT,
            date_time_text TEXT DEFAULT '28-Oktabr, 19:00',
            duration TEXT DEFAULT '90 daqiqa',
            is_free INTEGER DEFAULT 1,
            price_text TEXT,
            description TEXT,
            join_link TEXT,
            image TEXT,
            is_active INTEGER DEFAULT 1,
            sort_order INTEGER DEFAULT 0,
            created_at TEXT,
            updated_at TEXT
        );

        CREATE TABLE IF NOT EXISTS stats_counters (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            number TEXT NOT NULL,
            suffix TEXT DEFAULT '+',
            label TEXT NOT NULL,
            icon TEXT,
            sort_order INTEGER DEFAULT 0,
            created_at TEXT,
            updated_at TEXT
        );

        CREATE TABLE IF NOT EXISTS inquiries (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            phone TEXT NOT NULL,
            interest TEXT,
            message TEXT,
            status TEXT DEFAULT 'new',
            created_at TEXT,
            updated_at TEXT
        );

        CREATE TABLE IF NOT EXISTS quiz_questions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            question TEXT NOT NULL,
            option_a TEXT NOT NULL,
            option_b TEXT NOT NULL,
            option_c TEXT NOT NULL,
            option_d TEXT NOT NULL,
            correct_option TEXT NOT NULL,
            explanation TEXT,
            difficulty TEXT DEFAULT 'Ortacha',
            created_at TEXT,
            updated_at TEXT
        );
    `);

    const now = new Date().toISOString().replace('T', ' ').substring(0, 19);

    // 2. Admin User
    const existingAdmin = db.get('SELECT id FROM users WHERE email = ?', ['admin@biology.uz']);
    if (!existingAdmin) {
        const hashedPassword = bcrypt.hashSync('admin123', 10);
        db.run('INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', [
            'Biologiya Admin',
            'admin@biology.uz',
            hashedPassword,
            now,
            now
        ]);
        console.log('Admin user created: admin@biology.uz / admin123');
    }

    // 3. Settings
    const defaultSettings = {
        'site_name': 'BioSfera',
        'site_tagline': 'Zamonaviy Biologiya va Tibbiyot Ta\'lim Markazi',
        'phone_primary': '+998 (71) 200-45-45',
        'phone_secondary': '+998 (90) 840-05-05',
        'email': 'info@biosfera-edu.uz',
        'address': 'Toshkent sh., Yunusobod tumani, Amir Temur shoh ko\'chasi, 108',
        'working_hours': 'Dushanba - Shanba: 08:30 - 20:00',
        'telegram_url': 'https://t.me/biology_edu_uz',
        'telegram_channel': '@biology_edu_uz',
        'instagram_url': 'https://instagram.com/biology_edu_uz',
        'youtube_url': 'https://youtube.com/@biology_edu_uz',
        'facebook_url': 'https://facebook.com/biology_edu_uz',
        'hero_badge': 'Bepul Vebinar & Master-klass',
        'hero_title': 'BIOLOGIYA ILMI VA GENETIKA',
        'hero_subtitle': 'Professional biologlar, bo\'lajak tibbiyot talabalari va biologiya ixlosmandlari uchun interaktiv darslar, amaliy mikroskopiya va ilmiy tadqiqotlar portali.',
        'hero_btn_primary_text': 'Ro\'yxatdan o\'tish',
        'hero_btn_primary_link': '#register',
        'hero_btn_secondary_text': 'Batafsil ma\'lumot',
        'hero_btn_secondary_link': '#branches',
        'hero_image': '/images/hero-banner.jpg',
        'announcement_active': '1',
        'announcement_text': '🌿 28-Oktabr kuni xalqaro biolog mutaxassislar bilan bepul vebinar bo\'lib o\'tadi! Joylar soni cheklangan.',
        'theme_color': 'emerald'
    };

    for (const [k, v] of Object.entries(defaultSettings)) {
        db.updateSetting(k, v);
    }

    console.log('Database seeding finished successfully!');
}

if (require.main === module) {
    seedDatabase();
}

module.exports = seedDatabase;
