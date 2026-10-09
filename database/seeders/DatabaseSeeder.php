<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Article;
use App\Models\Webinar;
use App\Models\StatsCounter;
use App\Models\QuizQuestion;
use App\Models\Inquiry;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin Foydalanuvchisi
        User::firstOrCreate(
            ['email' => 'admin@biology.uz'],
            [
                'name' => 'Biologiya Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Sayt Sozlamalari (Settings)
        $settings = [
            'site_name' => 'BioSfera',
            'site_tagline' => 'Zamonaviy Biologiya va Tibbiyot Ta\'lim Markazi',
            'phone_primary' => '+998 (71) 200-45-45',
            'phone_secondary' => '+998 (90) 840-05-05',
            'email' => 'info@biosfera-edu.uz',
            'address' => 'Toshkent sh., Yunusobod tumani, Amir Temur shoh ko\'chasi, 108',
            'working_hours' => 'Dushanba - Shanba: 08:30 - 20:00',
            
            // Social Networks (User explicitly requested Instagram and Telegram)
            'telegram_url' => 'https://t.me/biology_edu_uz',
            'telegram_channel' => '@biology_edu_uz',
            'instagram_url' => 'https://instagram.com/biology_edu_uz',
            'youtube_url' => 'https://youtube.com/@biology_edu_uz',
            'facebook_url' => 'https://facebook.com/biology_edu_uz',
            
            // Hero section texts
            'hero_badge' => 'Bepul Vebinar & Master-klass',
            'hero_title' => 'BIOLOGIYA ILMI VA GENETIKA',
            'hero_subtitle' => 'Professional biologlar, bo\'lajak tibbiyot talabalari va biologiya ixlosmandlari uchun interaktiv darslar, amaliy mikroskopiya va ilmiy tadqiqotlar portali.',
            'hero_btn_primary_text' => 'Ro\'yxatdan o\'tish',
            'hero_btn_primary_link' => '#register',
            'hero_btn_secondary_text' => 'Batafsil ma\'lumot',
            'hero_btn_secondary_link' => '#courses',
            'hero_image' => '/images/hero-banner.jpg',
            
            // Top announcement bar
            'announcement_active' => '1',
            'announcement_text' => '🌿 28-Oktabr kuni xalqaro biolog mutaxassislar bilan bepul vebinar bo\'lib o\'tadi! Joylar soni cheklangan.',
            
            // Visual Theme Accent
            'theme_color' => 'emerald', // emerald, forest, cyan, teal
        ];

        foreach ($settings as $key => $val) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 3. Stats Counters (Matching screenshot style: 4000+, 3500+, 1500+, 5500+)
        $counters = [
            ['number' => '4000', 'suffix' => '+', 'label' => 'Muvaffaqiyatli O\'quvchilar', 'icon' => 'mortarboard', 'sort_order' => 1],
            ['number' => '3500', 'suffix' => '+', 'label' => 'Video va Audio Darslar', 'icon' => 'play-circle', 'sort_order' => 2],
            ['number' => '1500', 'suffix' => '+', 'label' => 'Laboratoriya Tajribalari', 'icon' => 'funnel', 'sort_order' => 3],
            ['number' => '5500', 'suffix' => '+', 'label' => 'Interaktiv Test Savollari', 'icon' => 'check2-all', 'sort_order' => 4],
        ];

        foreach ($counters as $c) {
            StatsCounter::create($c);
        }

        // 4. Categories (Biologiya asosiy bo'limlari)
        $categories = [
            [
                'name' => 'Botanika va O\'simliklar Fiziologiyasi',
                'slug' => 'botanika',
                'icon' => 'flower1',
                'color' => 'emerald',
                'description' => 'Flora dunyosi, o\'simlik to\'qimalari, fotosintez jarayoni va yashil tabiat sirlari.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Zoologiya va Jonivorlar Ekotizimi',
                'slug' => 'zoologiya',
                'icon' => 'feather',
                'color' => 'teal',
                'description' => 'Hayvonot olami xilma-xilligi, umurtqasizlar va umurtqalilar anatomiyasi hamda xulq-atvori.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Sitologiya va Hujayra Biologiyasi',
                'slug' => 'sitologiya',
                'icon' => 'bullseye',
                'color' => 'green',
                'description' => 'Hayotning eng kichik birligi – hujayra tuzilishi, mitoxondriya, membranalar va bo\'linish jarayonlari.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Molekulyar Genetika va Seleksiya',
                'slug' => 'genetika',
                'icon' => 'diagram-3',
                'color' => 'emerald',
                'description' => 'DNK va RNK tuzilishi, irsiyat qonuniyatlari, genetik kod va zamonaviy gen muhandisligi.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Odam Anatomiyasi va Fiziologiyasi',
                'slug' => 'anatomiya',
                'icon' => 'heart-pulse',
                'color' => 'rose',
                'description' => 'Inson organizmi, qon-tomir, asab, nafas va hazm tizimlarining mukammal ishlash mexanizmi.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Biotexnologiya va Mikrobiologiya',
                'slug' => 'biotexnologiya',
                'icon' => 'capsule',
                'color' => 'cyan',
                'description' => 'Bakteriyalar, viruslar, biotexnologik sintez, vaksinalar va kelajak tibbiyoti.',
                'sort_order' => 6,
            ],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[$cat['slug']] = Category::create($cat);
        }

        // 5. Maqolalar (Articles)
        $articles = [
            [
                'category_id' => $createdCategories['genetika']->id,
                'title' => 'CRISPR-Cas9: Genom Tahrirlash Va Kelajak Tibbiyoti Inqilobi',
                'slug' => 'crispr-cas9-genom-tahrirlash',
                'excerpt' => 'Gen muhandisligidagi eng yirik kashfiyotlardan biri bo\'lgan CRISPR tizimi insoniyatga irsiy kasalliklarni ildizidan davolash imkonini bermoqda.',
                'content' => '<p>CRISPR-Cas9 texnologiyasi bakteriyalarning viruslarga qarshi immun himoya mexanizmidan olingan bo\'lib, bugungi kunda molekulyar genetika sohasida haqiqiy burilish yasadi. Ushbu usul orqali olimlar DNK zanjirining aniq kerakli bo\'lagini molekulyar "qaychi" kabi kesib, nuqsonli genlarni sog\'lom nusxalarga almashtirish imkoniyatiga ega bo\'lishmoqda.</p><p>Tadqiqotlar shuni ko\'rsatadiki, yaqin yillarda ushbu usul yordamida o\'roqsimon hujayrali anemiya, ko\'rlikning ayrim irsiy turlari va hatto saraton hujayralarining genetik modifikatsiyasini to\'xtatish mumkin bo\'ladi.</p>',
                'image' => '/images/promo-banner.jpg',
                'read_time' => '6 daqiqa',
                'views_count' => 1420,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'category_id' => $createdCategories['botanika']->id,
                'title' => 'Fotosintezning Qorong\'ilik Fazasi (Kalvin Sikli) Sir-Asrorlari',
                'slug' => 'fotosintez-kalvin-sikli',
                'excerpt' => 'O\'simliklar qanday qilib oddiy quyosh nuri, suv va karbonat angidrid gazidan hayot uchun zarur bo\'lgan glyukoza va kislorodni hosil qiladi?',
                'content' => '<p>Fotosintez — yer yuzidagi barcha organik hayotning asosi hisoblanadi. O\'simlik xloroplastlarida kechuvchi ushbu jarayon ikki asosiy bosqichdan: yorug\'lik va qorong\'ilik (Kalvin sikli) fazalaridan iborat.</p><p>Yorug\'lik bosqichida ATF va NADF·H kabi energiya manbalari to\'planadi, Kalvin siklida esa Rubisco fermenti ishtirokida CO2 molekulalari organik birikmalarga aylanadi. Bu jarayon biologiya imtihonlarida eng ko\'p uchraydigan muhim mavzulardan biridir.</p>',
                'image' => '/images/hero-banner.jpg',
                'read_time' => '4 daqiqa',
                'views_count' => 980,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'category_id' => $createdCategories['anatomiya']->id,
                'title' => 'Inson Asab Tizimi: Sinapslar va Neyromediatorlar Qanday Ishlaydi?',
                'slug' => 'inson-asab-tizimi-sinapslar',
                'excerpt' => 'Miyaning 86 milliard neyroni bir-biri bilan elektr impulslari va kimyoviy moddalar orqali bir soniyada millionlab ma\'lumotlarni almashadi.',
                'content' => '<p>Har bir fikrimiz, harakatimiz va his-tuyg\'ularimiz neyronlar orasidagi sinaps deb ataluvchi maxsus tutashuv joylarida uzatiluvchi signallar natijasidir. Dopamin, serotonin va asetilxolin kabi neyromediatorlar bu zanjirning asosiy xabarchilaridir.</p><p>Ushbu mavzuni o\'rganish tibbiyot institutlariga kirish imtihonlarida va neyrobiologiya sohasida mustahkam poydevor yaratadi.</p>',
                'image' => '/images/promo-banner.jpg',
                'read_time' => '5 daqiqa',
                'views_count' => 1250,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'category_id' => $createdCategories['sitologiya']->id,
                'title' => 'Mitoz va Meyoz: Hujayra Bo\'linishidagi Asosiy Farqlar',
                'slug' => 'mitoz-va-meyoz-farqlari',
                'excerpt' => 'Tana hujayralarining ko\'payishi bilan jinsiy hujayralar shakllanishidagi xromosomalar to\'plami o\'zgarishini ko\'rgazmali tahlil qilamiz.',
                'content' => '<p>Mitoz bo\'linish orqali tana to\'qimalari yangilanadi va o\'sadi (diploid to\'plam saqlanadi). Meyoz bo\'linish natijasida esa xromosomalar soni ikki barobar qisqarib, gaploid jinsiy hujayralar (gametalar) vujudga keladi. Krossingover jarayoni esa genetik xilma-xillikni ta\'minlaydi.</p>',
                'image' => '/images/hero-banner.jpg',
                'read_time' => '4 daqiqa',
                'views_count' => 1100,
                'is_featured' => false,
                'is_published' => true,
            ],
        ];

        foreach ($articles as $art) {
            Article::create($art);
        }

        // 6. Reklama va Promo Bannerlar (User explicitly requested advertisement banner updates)
        Banner::create([
            'title' => 'Biologiya va Tibbiyot Olimpiadasiga Tayyorgarlik kursi',
            'badge' => 'Chegirma -30%',
            'description' => 'Respublika va xalqaro biologiya olimpiadalarida sovrinli o\'rinlarni egallashni istaysizmi? Ekspert murabbiylarimiz bilan maxsus intensiv kursga qo\'shiling!',
            'button_text' => 'Batafsil ma\'lumot & Yozilish',
            'button_url' => '#register',
            'image' => '/images/promo-banner.jpg',
            'position' => 'middle_feed',
            'bg_gradient' => 'from-emerald-800 to-teal-900',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Banner::create([
            'title' => 'Bepul Vebinar: O\'simliklar Hujayra Strukturasi va Genetikasi',
            'badge' => 'Ochiq Dars',
            'description' => 'Xalqaro ilmiy tadqiqotchilar ishtirokidagi master-klass. Jonli efirda savollaringizga to\'g\'ridan-to\'g\'ri javob oling.',
            'button_text' => 'Telegram orqali ulanish',
            'button_url' => 'https://t.me/biology_edu_uz',
            'image' => '/images/hero-banner.jpg',
            'position' => 'hero_bottom',
            'bg_gradient' => 'from-emerald-700 to-green-900',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // 7. Vebinarlar (Webinars / Online lessons)
        $webinars = [
            [
                'title' => 'O\'simliklar Biologiyasining Ilg\'or Sirlari: Xloroplastlar va DNK',
                'badge' => 'Bepul Vebinar',
                'instructor_name' => 'Prof. Lian Chen & Dr. Eliza Reed',
                'instructor_title' => 'Molekulyar biologiya va biotexnologiya kafedrasi professori',
                'date_time_text' => '28-Oktabr, 18:30',
                'duration' => '1 soat 30 daqiqa',
                'is_free' => true,
                'price_text' => 'BEPUL',
                'description' => 'Hujayra ichidagi organellalar harakati, genetik kod tahlili va amaliy mikroskopiya namoyishi.',
                'join_link' => '#register',
                'image' => '/images/promo-banner.jpg',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Tibbiyotga Tayyorgarlik: Inson Qon-tomir va Yurak Tizimi',
                'badge' => 'Amaliy Dars',
                'instructor_name' => 'Dr. Jasur Aliyev',
                'instructor_title' => 'Kardiolog-shifokor, biologiya bo\'yicha fan nomzodi',
                'date_time_text' => '3-Noyabr, 19:00',
                'duration' => '2 soat',
                'is_free' => true,
                'price_text' => 'BEPUL',
                'description' => 'Yurak sikli, qon bosimi mexanizmlari va EKG asoslari haqida o\'quvchilar uchun sodda va qiziqarli dars.',
                'join_link' => '#register',
                'image' => '/images/hero-banner.jpg',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($webinars as $web) {
            Webinar::create($web);
        }

        // 8. Interaktiv Biologiya Viktorina Savollari (Interactive Quiz)
        $quizQuestions = [
            [
                'question' => 'O\'simlik hujayrasida fotosintez jarayoni qaysi organellada amalga oshadi?',
                'option_a' => 'Ribosoma',
                'option_b' => 'Xloroplast',
                'option_c' => 'Mitoxondriya',
                'option_d' => 'Goldji apparati',
                'correct_option' => 'b',
                'explanation' => 'Fotosintez xlorofill pigmentini o\'z ichiga olgan xloroplast organellalarida yuz beradi.',
                'difficulty' => 'Oson',
            ],
            [
                'question' => 'Odam organizmida qonning gaz almashinuvini (kislorod va karbonat angidrid) qaysi hujayralar ta\'minlaydi?',
                'option_a' => 'Eritrotsitlar (gemoglobin bilan)',
                'option_b' => 'Leykotsitlar',
                'option_c' => 'Trombotsitlar',
                'option_d' => 'Neyronlar',
                'correct_option' => 'a',
                'explanation' => 'Eritrotsitlar tarkibidagi gemoglobin oqsili kislorod va qisman karbonat angidrid gazini tashiydi.',
                'difficulty' => 'Ortacha',
            ],
            [
                'question' => 'DNK molekulasida adenin (A) nukleotidiga komplementar bo\'lgan nukleotid qaysi?',
                'option_a' => 'Sitozin (C)',
                'option_b' => 'Guanin (G)',
                'option_c' => 'Timin (T)',
                'option_d' => 'Urasil (U)',
                'correct_option' => 'c',
                'explanation' => 'DNK qo\'sh spiralida Chargaff qoidasiga ko\'ra Adenin faqat Timin (A=T) bilan ikkita vodorod bog\'i orqali bog\'lanadi.',
                'difficulty' => 'Ortacha',
            ],
        ];

        foreach ($quizQuestions as $q) {
            QuizQuestion::create($q);
        }

        // 9. Namunaviy arizalar (Inquiries)
        Inquiry::create([
            'name' => 'Dilnoza Karimova',
            'phone' => '+998 90 123 45 67',
            'interest' => 'Bepul Vebinarga yozilish',
            'message' => 'Molekulyar genetika bo\'yicha vebinar linkini yuboring iltimos.',
            'status' => 'new',
        ]);
        Inquiry::create([
            'name' => 'Sardorbek Ergashev',
            'phone' => '+998 97 765 43 21',
            'interest' => 'Olimpiada kursi',
            'message' => 'Biologiya olimpiadasiga tayyorgarlik kursi jadvali qiziqtirdi.',
            'status' => 'contacted',
        ]);
    }
}
