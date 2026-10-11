const multer = require('multer');
const path = require('node:path');
const fs = require('node:fs');

const uploadDir = path.join(__dirname, '..', 'public', 'images');
if (!fs.existsSync(uploadDir)) {
    fs.mkdirSync(uploadDir, { recursive: true });
}

const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, uploadDir);
    },
    filename: (req, file, cb) => {
        const ext = path.extname(file.originalname);
        let prefix = 'file';
        if (file.fieldname.includes('hero')) prefix = 'hero';
        else if (file.fieldname.includes('banner') || req.baseUrl.includes('banner')) prefix = 'banner';
        else if (file.fieldname.includes('article') || req.baseUrl.includes('article')) prefix = 'art';
        else if (file.fieldname.includes('webinar') || req.baseUrl.includes('webinar')) prefix = 'web';
        
        cb(null, `${prefix}_${Date.now()}${ext}`);
    }
});

const upload = multer({
    storage,
    limits: { fileSize: 10 * 1024 * 1024 } // 10MB
});

module.exports = upload;
