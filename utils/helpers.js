function formatDate(dateStr, format = 'd.m.Y') {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    if (isNaN(d.getTime())) return dateStr;

    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');

    if (format === 'd.m.Y H:i') {
        return `${day}.${month}.${year} ${hours}:${minutes}`;
    }
    return `${day}.${month}.${year}`;
}

function slugify(text) {
    if (!text) return '';
    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/['`’]/g, '')
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
}

function numberFormat(num) {
    if (num === null || num === undefined) return '0';
    return Number(num).toLocaleString('uz-UZ');
}

function truncate(text, len = 100) {
    if (!text) return '';
    if (text.length <= len) return text;
    return text.substring(0, len) + '...';
}

module.exports = {
    formatDate,
    slugify,
    numberFormat,
    truncate
};
