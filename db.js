const { DatabaseSync } = require('node:sqlite');
const path = require('node:path');

const dbPath = path.join(__dirname, 'database', 'database.sqlite');
const db = new DatabaseSync(dbPath);

// Enable WAL mode and foreign keys for performance and consistency
db.exec('PRAGMA foreign_keys = ON;');

module.exports = {
    db,

    all(sql, params = []) {
        const stmt = db.prepare(sql);
        return stmt.all(...params);
    },

    get(sql, params = []) {
        const stmt = db.prepare(sql);
        return stmt.get(...params);
    },

    run(sql, params = []) {
        const stmt = db.prepare(sql);
        return stmt.run(...params);
    },

    // Site settings helper
    getAllSettings() {
        const rows = this.all('SELECT key, value FROM site_settings');
        const settings = {};
        for (const row of rows) {
            settings[row.key] = row.value;
        }
        return settings;
    },

    updateSetting(key, value) {
        const existing = this.get('SELECT id FROM site_settings WHERE key = ?', [key]);
        const now = new Date().toISOString().replace('T', ' ').substring(0, 19);
        if (existing) {
            this.run('UPDATE site_settings SET value = ?, updated_at = ? WHERE key = ?', [value, now, key]);
        } else {
            this.run('INSERT INTO site_settings (key, value, group, created_at, updated_at) VALUES (?, ?, ?, ?, ?)', [key, value, 'general', now, now]);
        }
    }
};
