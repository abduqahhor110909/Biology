const db = require('../db');

function requireAuth(req, res, next) {
    if (!req.session.userId) {
        return res.redirect('/admin/login');
    }

    const user = db.get('SELECT id, name, email FROM users WHERE id = ?', [req.session.userId]);
    if (!user) {
        req.session.destroy();
        return res.redirect('/admin/login');
    }

    req.user = user;
    res.locals.user = user;
    next();
}

module.exports = {
    requireAuth
};
