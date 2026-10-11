# BioSfera - Biologiya va Tibbiyot Ta'lim Portali (Node.js)

Ushbu loyiha zamonaviy biologiya, biotexnologiya va tibbiyot ta'lim platformasi bo'lib, to'liq **Node.js (Express.js)** va **SQLite** asosida ishlaydi.

## Asosiy Texnologiyalar
- **Backend Muhiti**: Node.js (Express.js)
- **Shablonlar Dvigateli (Views)**: EJS & express-ejs-layouts
- **Ma'lumotlar Bazasi**: SQLite (`node:sqlite` DatabaseSync)
- **Autentifikatsiya**: Express-Session & Bcryptjs
- **Fayllar Yuklash**: Multer
- **Frontend**: HTML5, CSS3, Vanilla JavaScript, Bootstrap Icons

---

## Loyihani Ishga Tushirish

### 1. Bog'liqliklarni o'rnatish
```bash
npm install
```

### 2. Loyihani ishga tushirish
Oddiy rejimda:
```bash
npm start
```

Rivojlantirish (dev watch) rejimida:
```bash
npm run dev
```

Server odatiy tarzda `http://localhost:3000` portida ishga tushadi.

---

## Boshqaruv Paneli (Admin Panel)

- **Kirish manzili**: `http://localhost:3000/admin/login`
- **Email**: `admin@biology.uz`
- **Parol**: `admin123`

### Admin panel imkoniyatlari:
1. **Dashboard**: Umumiy statistika ko'rsatkichlari, so'nggi arizalar, faol bannerlar.
2. **Sayt Sozlamalari**: Telegram va Instagram havolalari, telefon raqamlar, hero sarlavha va matnlar, hero rasmi, yuqori e'lon lentasi.
3. **Reklama va Bannerlar**: Reklamalarni qo'shish, tahrirlash, o'chirish va faollik holatini bitta tugma bilan o'zgartirish.
4. **Biologiya Maqolalari**: Ilmiy maqolalarni yaratish, tahrirlash, avtomatik slug generatsiyasi, rasm biriktirish.
5. **Vebinarlar va Darslar**: Onlayn darslar, bepul/pullik vebinarlar e'lon qilish.
6. **Statistika Hisoblagichlari**: Bosh sahifadagi 4000+, 3500+, 1500+, 5500+ hisoblagichlarini istalgan vaqt o'zgartirish.
7. **Kelib Tushgan Arizalar**: Sayt orqali foydalanuvchilar qoldirgan arizalarni ko'rish, holatini (Yangi, Bog'lanildi, Tugallangan) o'zgartirish yoki o'chirish.

---

## Loyiha Tuzilishi

```
biology/
├── database/
│   └── database.sqlite    # SQLite ma'lumotlar bazasi
├── middleware/
│   └── auth.js            # Admin sessiya tekshiruvi
├── public/
│   ├── css/               # Asosiy va admin stillari (main.css, admin.css)
│   ├── js/                # Client JavaScript (main.js)
│   └── images/            # Yuklangan banner va maqola rasmlari
├── routes/
│   ├── public.js          # Ommaviy sahifalar marshrutlari
│   └── admin.js           # Admin boshqaruv marshrutlari
├── utils/
│   ├── helpers.js         # Sana formatlash, slug va matn funksiyalari
│   └── uploader.js        # Multer rasm yuklash konfiguratsiyasi
├── views/
│   ├── admin/             # Admin panel shablonlari
│   ├── layouts/           # Asosiy va admin layoutlari (app.ejs, admin.ejs)
│   ├── partials/          # Qayta ishlatiluvchi qismlar (pagination)
│   ├── home.ejs           # Bosh sahifa
│   ├── article.ejs        # Maqola sahifasi
│   └── 404.ejs            # Xatolik sahifasi
├── db.js                  # SQLite ulanishi va yordamchi metodlar
├── seed.js                # Dastlabki ma'lumotlarni bazaga yozish skripti
├── server.js              # Express server kirish nuqtasi
├── package.json           # Node.js loyiha konfiguratsiyasi
└── .env                   # Muhit parametrlari (PORT, SESSION_SECRET)
```
