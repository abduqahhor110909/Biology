const express = require('express');
const session = require('express-session');
const flash = require('connect-flash');
const expressLayouts = require('express-ejs-layouts');
const path = require('node:path');
const db = require('./db');

// Load environment variables if .env file exists
if (process.loadEnvFile) {
    try {
        process.loadEnvFile();
    } catch (e) {
        // .env not present or already in environment
    }
}

const app = express();
const PORT = process.env.PORT || 3000;

// View engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');
app.use(expressLayouts);
app.set('layout', 'layouts/app');
app.set('layout extractScripts', false);
app.set('layout extractStyles', false);

// Static assets
app.use(express.static(path.join(__dirname, 'public')));

// Request parsing
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// Session setup
app.use(session({
    secret: process.env.SESSION_SECRET || 'biology_platform_super_secret_key_2026',
    resave: false,
    saveUninitialized: false,
    cookie: {
        maxAge: 1000 * 60 * 60 * 24 * 7 // 7 days
    }
}));

// Flash messages
app.use(flash());

// Global locals for views
app.use((req, res, next) => {
    res.locals.success = req.flash('success');
    res.locals.error = req.flash('error');
    res.locals.info = req.flash('info');
    res.locals.currentPath = req.path;
    res.locals.user = req.session && req.session.userId ? db.get('SELECT id, name, email FROM users WHERE id = ?', [req.session.userId]) : null;
    res.locals.settings = db.getAllSettings();
    next();
});

// Routes
const publicRoutes = require('./routes/public');
const adminRoutes = require('./routes/admin');

app.use('/admin', adminRoutes);
app.use('/', publicRoutes);

// 404 Fallback
app.use((req, res) => {
    const settings = db.getAllSettings();
    res.status(404).render('404', {
        layout: 'layouts/app',
        settings,
        message: 'Kechirasiz, bunday sahifa mavjud emas.'
    });
});

// Error handling
app.use((err, req, res, next) => {
    console.error('Server error:', err);
    res.status(500).send('Serverda xatolik yuz berdi.');
});

// Start server
app.listen(PORT, () => {
    console.log(`===============================================`);
    console.log(` BioSfera Node.js server ishga tushdi!`);
    console.log(` Sayt manzili: http://localhost:${PORT}`);
    console.log(` Admin panel:  http://localhost:${PORT}/admin/login`);
    console.log(`===============================================`);
});
