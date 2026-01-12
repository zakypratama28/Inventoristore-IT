<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $admin = User::first();
        }

        $articles = [
            [
                'title' => 'Review Lengkap ASUS TUF Gaming A15 2024: Laptop Gaming Tangguh dengan Performa Maksimal',
                'slug' => 'review-asus-tuf-gaming-a15-2024',
                'excerpt' => 'Laptop gaming ASUS TUF Gaming A15 2024 hadir dengan prosesor AMD Ryzen 7000 series dan GPU NVIDIA RTX 4000 series, menawarkan performa gaming maksimal dengan harga terjangkau.',
                'content' => '<h2>Spesifikasi Unggulan</h2>
                <p>ASUS TUF Gaming A15 2024 merupakan pilihan sempurna bagi gamers yang mencari laptop dengan performa tinggi namun tetap dalam budget yang masuk akal. Laptop ini ditenagai oleh prosesor <strong>AMD Ryzen 7 7735HS</strong> yang mampu mencapai clock speed hingga 4.75 GHz.</p>
                
                <h3>Performa Gaming</h3>
                <p>Dengan <strong>NVIDIA GeForce RTX 4060 8GB</strong>, laptop ini mampu menjalankan game AAA terbaru seperti Cyberpunk 2077, Elden Ring, dan Call of Duty dengan setting ultra pada resolusi 1080p dengan frame rate stabil di atas 60 fps.</p>
                
                <ul>
                    <li>Prosesor: AMD Ryzen 7 7735HS (8-core, 16-thread)</li>
                    <li>GPU: NVIDIA GeForce RTX 4060 8GB GDDR6</li>
                    <li>RAM: 16GB DDR5-4800MHz (upgradeable hingga 32GB)</li>
                    <li>Storage: 512GB PCIe 4.0 NVMe SSD</li>
                    <li>Display: 15.6" FHD (1920x1080) 144Hz IPS-level</li>
                    <li>Cooling: Arc Flow Fans dengan 4 heat pipes</li>
                </ul>
                
                <h3>Desain & Build Quality</h3>
                <p>TUF Gaming A15 mengusung desain military-grade dengan sertifikasi <strong>MIL-STD-810H</strong>, menjadikannya tahan terhadap benturan, getaran, dan suhu ekstrem. Chassis-nya terbuat dari plastik reinforced yang kokoh namun tetap ringan dengan bobot sekitar 2.3 kg.</p>
                
                <h3>Sistem Pendingin</h3>
                <p>ASUS menghadirkan teknologi <strong>Arc Flow Fans</strong> generasi terbaru dengan 84 bilah kipas yang lebih tipis, meningkatkan airflow hingga 13% dibanding generasi sebelumnya. Dikombinasikan dengan 4 heat pipes dan thermal compound kualitas tinggi, laptop ini mampu menjaga suhu tetap optimal bahkan saat gaming marathon.</p>
                
                <h3>Baterai & Konektivitas</h3>
                <p>Dilengkapi dengan baterai 90Wh yang mendukung fast charging 150W, laptop ini mampu bertahan hingga 8-9 jam untuk produktivitas ringan. Untuk konektivitas, tersedia:</p>
                <ul>
                    <li>1x USB 3.2 Gen 2 Type-C (dengan DisplayPort & Power Delivery)</li>
                    <li>3x USB 3.2 Gen 1 Type-A</li>
                    <li>1x HDMI 2.1</li>
                    <li>1x RJ45 LAN</li>
                    <li>1x Audio combo jack</li>
                    <li>Wi-Fi 6E & Bluetooth 5.3</li>
                </ul>
                
                <h3>Kesimpulan</h3>
                <p>ASUS TUF Gaming A15 2024 adalah pilihan excellent untuk gamers dengan budget Rp 15-20 juta. Performa gaming yang powerful, build quality yang solid, dan thermal management yang baik menjadikan laptop ini value for money terbaik di kelasnya.</p>
                
                <p><strong>Rating: 4.5/5</strong></p>
                <p><em>Harga: Mulai dari Rp 16.999.000</em></p>',
                'category' => 'Gaming',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'views' => rand(150, 500)
            ],
            [
                'title' => 'Lenovo Legion 5 Pro vs Legion 7: Mana yang Lebih Worth It untuk Gaming?',
                'slug' => 'lenovo-legion-5-pro-vs-legion-7',
                'excerpt' => 'Perbandingan mendalam antara Lenovo Legion 5 Pro dan Legion 7, dua laptop gaming premium dari Lenovo. Temukan mana yang paling sesuai dengan kebutuhan dan budget Anda.',
                'content' => '<h2>Perbandingan Lengkap Legion 5 Pro vs Legion 7</h2>
                <p>Lenovo Legion series telah menjadi favorit gamers berkat kombinasi performa tinggi dan desain premium. Kali ini kita akan membandingkan dua flagship mereka: <strong>Legion 5 Pro</strong> dan <strong>Legion 7</strong>.</p>
                
                <h3>Desain & Build Quality</h3>
                <p><strong>Legion 5 Pro:</strong> Menggunakan chassis plastik premium dengan aksen metal di hinge. Design lebih subtle dengan RGB lighting minimal. Bobot sekitar 2.5 kg.</p>
                <p><strong>Legion 7:</strong> Full metal chassis aluminum yang lebih premium dengan chamfered edges. RGB lighting lebih extensive dengan Lenovo Spectrum RGB. Bobot sekitar 2.4 kg meski lebih tipis.</p>
                
                <h3>Spesifikasi Teknis</h3>
                <table border="1" style="width:100%; border-collapse: collapse; margin: 20px 0;">
                    <tr style="background-color: #f0f0f0;">
                        <th style="padding: 10px;">Komponen</th>
                        <th style="padding: 10px;">Legion 5 Pro</th>
                        <th style="padding: 10px;">Legion 7</th>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Prosesor</td>
                        <td style="padding: 10px;">AMD Ryzen 7 7745HX</td>
                        <td style="padding: 10px;">AMD Ryzen 9 7945HX</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">GPU</td>
                        <td style="padding: 10px;">RTX 4060/4070</td>
                        <td style="padding: 10px;">RTX 4070/4080</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Display</td>
                        <td style="padding: 10px;">16" WQXGA 165Hz</td>
                        <td style="padding: 10px;">16" WQXGA 240Hz</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">TGP GPU</td>
                        <td style="padding: 10px;">140W</td>
                        <td style="padding: 10px;">150W</td>
                    </tr>
                </table>
                
                <h3>Performa Gaming</h3>
                <p><strong>Legion 5 Pro</strong> dengan RTX 4070 mampu:</p>
                <ul>
                    <li>Cyberpunk 2077 (Ultra, DLSS Quality): 75-85 FPS @ 1600p</li>
                    <li>Elden Ring (Max Settings): 120+ FPS @ 1600p</li>
                    <li>Call of Duty MW3 (Ultra): 140-160 FPS @ 1600p</li>
                </ul>
                
                <p><strong>Legion 7</strong> dengan RTX 4080 mampu:</p>
                <ul>
                    <li>Cyberpunk 2077 (Ultra, DLSS Quality): 95-110 FPS @ 1600p</li>
                    <li>Elden Ring (Max Settings): Locked 165 FPS</li>
                    <li>Call of Duty MW3 (Ultra): 180-200 FPS @ 1600p</li>
                </ul>
                
                <h3>Thermal & Noise</h3>
                <p>Kedua laptop menggunakan <strong>Lenovo Legion Coldfront 5.0</strong> dengan vapor chamber. Legion 7 memiliki sistem pendingin lebih advanced dengan lebih banyak heat pipes, menghasilkan suhu lebih rendah 3-5°C saat gaming intensive.</p>
                
                <h3>Display Quality</h3>
                <p>Keduanya menggunakan panel 16" WQXGA (2560x1600) 16:10 aspect ratio, sempurna untuk gaming dan productivity. Legion 7 unggul dengan refresh rate 240Hz vs 165Hz pada Legion 5 Pro, memberikan competitive advantage di game esports.</p>
                
                <h3>Harga & Value</h3>
                <p><strong>Legion 5 Pro (RTX 4070):</strong> Rp 24.999.000</p>
                <p><strong>Legion 7 (RTX 4070):</strong> Rp 29.999.000</p>
                <p><strong>Legion 7 (RTX 4080):</strong> Rp 39.999.000</p>
                
                <h3>Kesimpulan</h3>
                <p><strong>Pilih Legion 5 Pro jika:</strong></p>
                <ul>
                    <li>Budget maksimal Rp 25 juta</li>
                    <li>Gaming di 1080p-1600p sudah cukup</li>
                    <li>Tidak terlalu peduli dengan premium materials</li>
                </ul>
                
                <p><strong>Pilih Legion 7 jika:</strong></p>
                <ul>
                    <li>Menginginkan performa absolut terbaik</li>
                    <li>Main game competitive (butuh 240Hz)</li>
                    <li>Appreciate premium build quality</li>
                </ul>
                
                <p><strong>Verdict:</strong> Legion 5 Pro menawarkan value terbaik untuk kebanyakan gamers, sementara Legion 7 adalah pilihan ultimate untuk enthusiast yang tidak compromise.</p>',
                'category' => 'Gaming',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'views' => rand(200, 600)
            ],
            [
                'title' => 'Samsung Galaxy S24 Ultra: Smartphone Gaming Terbaik 2024 dengan Snapdragon 8 Gen 3',
                'slug' => 'samsung-galaxy-s24-ultra-gaming-review',
                'excerpt' => 'Review mendalam Samsung Galaxy S24 Ultra untuk gaming. Dengan Snapdragon 8 Gen 3, layar Dynamic AMOLED 2X 120Hz, dan sistem pendingin canggih, ini adalah flagship gaming terbaik tahun ini.',
                'content' => '<h2>Samsung Galaxy S24 Ultra: Beast Mode untuk Mobile Gaming</h2>
                <p>Samsung Galaxy S24 Ultra bukan hanya flagship biasa - ini adalah powerhouse gaming dengan spesifikasi yang setara dengan gaming phones dedicated, namun dengan features productivity yang lengkap.</p>
                
                <h3>Performa Gaming: Snapdragon 8 Gen 3 for Galaxy</h3>
                <p>S24 Ultra menggunakan varian special <strong>Snapdragon 8 Gen 3 for Galaxy</strong> yang di-overclock khusus untuk Samsung. CPU prime core berjalan di 3.39 GHz (vs 3.3 GHz versi standard), memberikan boost performance hingga 8% lebih tinggi.</p>
                
                <h4>Benchmark Scores:</h4>
                <ul>
                    <li><strong>AnTuTu:</strong> 1,850,000+ points</li>
                    <li><strong>GeekBench 6:</strong> Single-core 2,250 | Multi-core 7,100</li>
                    <li><strong>3DMark Wild Life Extreme:</strong> 5,200+ points</li>
                    <li><strong>GFXBench Manhattan 3.1:</strong> 187 FPS</li>
                </ul>
                
                <h3>Gaming Performance Real-World</h3>
                <p>Berikut performa S24 Ultra di game populer dengan setting maksimal:</p>
                
                <ul>
                    <li><strong>Genshin Impact (Max Settings, 60 FPS mode):</strong> Locked 60 FPS stabil, suhu stabil 38-40°C</li>
                    <li><strong>PUBG Mobile (90 FPS Ultra HD):</strong> Consistent 90 FPS, no frame drops</li>
                    <li><strong>Call of Duty Mobile (Max + 120 FPS):</strong> Locked 120 FPS</li>
                    <li><strong>Mobile Legends (Ultra Graphics, 120 FPS):</strong> Locked 120 FPS bahkan di teamfight</li>
                    <li><strong>Honkai: Star Rail (High Settings, 60 FPS):</strong> Stable 60 FPS</li>
                </ul>
                
                <h3>Display Gaming: Dynamic AMOLED 2X</h3>
                <p>Layar 6.8" QHD+ (3120x1440) dengan teknologi:</p>
                <ul>
                    <li><strong>Refresh Rate:</strong> Adaptive 1-120Hz (LTPO)</li>
                    <li><strong>Touch Sampling Rate:</strong> 240Hz untuk responsiveness maksimal</li>
                    <li><strong>Brightness:</strong> 2,600 nits peak (outdoor visibility terbaik)</li>
                    <li><strong>Color Accuracy:</strong> 100% DCI-P3, Delta E < 1</li>
                    <li><strong>Corning Gorilla Armor:</strong> Anti-reflective coating baru</li>
                </ul>
                
                <h3>Thermal Management & Battery</h3>
                <p>Samsung menggunakan <strong>vapor chamber</strong> yang 1.9x lebih besar dari S23 Ultra, ditambah dengan graphite sheets berlapis. Hasil? Gaming marathon 2 jam hanya naik ke suhu 39-41°C.</p>
                
                <p><strong>Baterai 5,000 mAh</strong> dengan optimasi AI mampu:</p>
                <ul>
                    <li>Gaming Genshin Impact: 7-8 jam continuous</li>
                    <li>PUBG Mobile: 9-10 jam continuous</li>
                    <li>Fast Charging: 45W (0-50% dalam 20 menit)</li>
                    <li>Wireless Charging: 15W</li>
                </ul>
                
                <h3>Audio Gaming</h3>
                <p>Dual stereo speakers tuned by AKG dengan Dolby Atmos Support. Volume maksimal mencapai 88dB - cukup keras untuk gaming session tanpa headphone.</p>
                
                <h3>Fitur Gaming Tambahan</h3>
                <ul>
                    <li><strong>Game Booster:</strong> AI-powered optimization</li>
                    <li><strong>Priority Mode:</strong> Block notifications saat gaming</li>
                    <li><strong>Performance Profiles:</strong> Standard, Optimized, Maximum</li>
                    <li><strong>Touch Sensitivity:</strong> Adjustable untuk game FPS</li>
                    <li><strong>Screen Recorder:</strong> Built-in dengan voice recording</li>
                </ul>
                
                <h3>Kamera: Bonus Point</h3>
                <p>Meski fokus gaming, S24 Ultra punya kamera terbaik di kelasnya:</p>
                <ul>
                    <li>200MP main (f/1.7)</li>
                    <li>50MP 5x periscope telephoto</li>
                    <li>10MP 3x telephoto</li>
                    <li>12MP ultra-wide</li>
                </ul>
                
                <h3>Kesimpulan</h3>
                <p>Samsung Galaxy S24 Ultra adalah smartphone gaming terbaik untuk yang mencari all-in-one device. Performa gaming setara ROG Phone, tapi dengan ekosistem Samsung yang mature dan kamera flagship.</p>
                
                <p><strong>Pros:</strong></p>
                <ul>
                    <li>Performa gaming top-tier</li>
                    <li>Display quality terbaik di kelasnya</li>
                    <li>Thermal management excellent</li>
                    <li>Battery life impressive</li>
                    <li>S Pen untuk productivity</li>
                </ul>
                
                <p><strong>Cons:</strong></p>
                <ul>
                    <li>Harga premium (mulai Rp 19.999.000)</li>
                    <li>Tidak ada 3.5mm jack</li>
                    <li>Berat 232g (sedikit berat untuk gaming long session)</li>
                </ul>
                
                <p><strong>Rating Gaming: 5/5</strong></p>
                <p><strong>Rating Overall: 4.8/5</strong></p>',
                'category' => 'Smartphone',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'views' => rand(300, 800)
            ],
            [
                'title' => 'Razer BlackShark V2 Pro Review: Headset Gaming Wireless Terbaik untuk Esports',
                'slug' => 'razer-blackshark-v2-pro-review',
                'excerpt' => 'Review lengkap Razer BlackShark V2 Pro, headset gaming wireless yang menjadi pilihan pro players. Dengan THX Spatial Audio dan latensi ultra-low, ini adalah endgame untuk competitive gaming.',
                'content' => '<h2>Razer BlackShark V2 Pro: Endgame Headset Esports</h2>
                <p>Razer BlackShark V2 Pro adalah iterasi terbaru dari line-up BlackShark yang sudah terbukti di scene esports. Digunakan oleh berbagai pro teams di Valorant, CS2, dan Apex Legends, headset ini menawarkan performa audio competitive yang uncompromising.</p>
                
                <h3>Design & Build Quality</h3>
                <p>BlackShark V2 Pro mengusung desain yang fokus pada <strong>comfort dan weight distribution</strong>. Dengan bobot hanya <strong>320 gram</strong>, ini salah satu wireless headset paling ringan di kelasnya.</p>
                
                <h4>Material & Construction:</h4>
                <ul>
                    <li>Headband: FlowKnit memory foam dengan breathable fabric</li>
                    <li>Earcups: Protein leather dengan cooling gel-infused cushions</li>
                    <li>Frame: Reinforced plastic dengan metal adjustment sliders</li>
                    <li>Clamping force: Medium (pas untuk long gaming sessions)</li>
                </ul>
                
                <h3>Audio Performance: Razer TriForce Titanium 50mm</h3>
                <p>Driver custom Razer dengan <strong>titanium coating</strong> memberikan clarity yang exceptional, terutama di mid-high frequencies crucial untuk footsteps dan positional audio.</p>
                
                <h4>Frequency Response:</h4>
                <ul>
                    <li><strong>Range:</strong> 12Hz - 28,000 Hz</li>
                    <li><strong>Impedance:</strong> 32 Ohms</li>
                    <li><strong>Sensitivity:</strong> 100 dBSPL/mW at 1 kHz</li>
                </ul>
                
                <h4>Sound Signature:</h4>
                <p>BlackShark V2 Pro memiliki tuning yang <strong>balanced dengan slight bass emphasis</strong>. Tidak over-exaggerated seperti kebanyakan "gaming" headsets, tapi cukup untuk immersion tanpa mengorbankan clarity.</p>
                
                <ul>
                    <li><strong>Bass:</strong> Tight dan controlled, punch bagus untuk explosions tapi tidak bleeding ke mids</li>
                    <li><strong>Mids:</strong> Clear dan forward, voice comms excellent</li>
                    <li><strong>Treble:</strong> Crisp tanpa sibilant, perfect untuk footsteps</li>
                    <li><strong>Soundstage:</strong> Good untuk closed-back, imaging very accurate</li>
                </ul>
                
                <h3>THX Spatial Audio & Razer Synapse</h3>
                <p>THX Spatial Audio memberikan <strong>virtual 7.1 surround</strong> yang actually useful untuk gaming. Tidak seperti implementations lain yang muddled, THX implementation Razer maintain clarity sambil expand soundstage.</p>
                
                <p>Via Razer Synapse software, tersedia:</p>
                <ul>
                    <li>Custom EQ (10-band parametric)</li>
                    <li>Game-specific profiles</li>
                    <li>Mic monitoring dengan adjustable volume</li>
                    <li>THX Game Profiles (optimized untuk specific games)</li>
                    <li>Battery indicator dan firmware updates</li>
                </ul>
                
                <h3>Microphone: Razer HyperClear Cardioid</h3>
                <p>Detachable boom mic dengan cardioid pattern memberikan voice quality yang comparable dengan standalone mics budget. Features:</p>
                
                <ul>
                    <li><strong>Pattern:</strong> Cardioid (fokus ke voice, reject background noise)</li>
                    <li><strong>Frequency Response:</strong> 100Hz - 10,000 Hz</li>
                    <li><strong>Sensitivity:</strong> -42 dBV/Pa</li>
                    <li><strong>Noise Cancellation:</strong> AI-powered via Synapse</li>
                </ul>
                
                <h3>Wireless Performance</h3>
                <p>Menggunakan <strong>Razer HyperSpeed Wireless 2.4GHz</strong> dengan latency claims <1ms. Dalam testing real-world:</p>
                
                <ul>
                    <li><strong>Latency:</strong> Imperceptible, identical to wired experience</li>
                    <li><strong>Range:</strong> 40+ meters line-of-sight, 15-20m dengan obstacles</li>
                    <li><strong>Stability:</strong> Zero dropouts dalam WiFi-dense environment</li>
                    <li><strong>Battery Life:</strong> 70 jam (manufacturer claim), real-world 60-65 jam</li>
                    <li><strong>Charging:</strong> USB-C, 15 menit charge = 6 jam usage</li>
                </ul>
                
                <h3>Gaming Performance</h3>
                
                <h4>FPS Games (Valorant, CS2, Apex):</h4>
                <p><strong>Excellent</strong> - Imaging sangat accurate untuk pinpoint enemy positions. Footsteps terdengar clear distinct dari background ambience. THX Spatial Audio membantu vertical audio cues.</p>
                
                <h4>Battle Royale (PUBG, Warzone):</h4>
                <p><strong>Very Good</strong> - Soundstage cukup wide untuk track multiple directions. Gunshot directions dan vehicle approach accuracy tinggi.</p>
                
                <h4>Single Player / Immersive (God of War, Cyberpunk):</h4>
                <p><strong>Great</strong> - Bass presence bagus untuk cinematic moments. Spatial audio adds immersion tanpa sounding artificial.</p>
                
                <h3>Comfort - Long Session Test</h3>
                <p>Tested dengan 8-hour gaming marathon:</p>
                <ul>
                    <li><strong>Hours 1-3:</strong> Barely noticeable, weight distribution excellent</li>
                    <li><strong>Hours 4-6:</strong> Masih comfortable, slight ear warmth dari gel cushions</li>
                    <li><strong>Hours 7-8:</strong> Mulai sedikit pressure di headband, tapi masih tolerable</li>
                </ul>
                
                <p>Cooling gel cushions bekerja well - tidak overheating meski long sessions. Clamping force balanced - tidak terlalu loose tapi tidak menyebabkan headache.</p>
                
                <h3>Perbandingan dengan Kompetitor</h3>
                
                <table border="1" style="width:100%; border-collapse: collapse; margin: 20px 0;">
                    <tr style="background-color: #f0f0f0;">
                        <th style="padding: 10px;">Feature</th>
                        <th style="padding: 10px;">BlackShark V2 Pro</th>
                        <th style="padding: 10px;">SteelSeries Arctis Nova Pro</th>
                        <th style="padding: 10px;">Logitech G Pro X2</th>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Harga</td>
                        <td style="padding: 10px;">Rp 3.299.000</td>
                        <td style="padding: 10px;">Rp 5.499.000</td>
                        <td style="padding: 10px;">Rp 4.299.000</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Weight</td>
                        <td style="padding: 10px;">320g</td>
                        <td style="padding: 10px;">370g</td>
                        <td style="padding: 10px;">345g</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Battery</td>
                        <td style="padding: 10px;">70h</td>
                        <td style="padding: 10px;">44h</td>
                        <td style="padding: 10px;">50h</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Sound Quality</td>
                        <td style="padding: 10px;">Excellent</td>
                        <td style="padding: 10px;">Excellent+</td>
                        <td style="padding: 10px;">Excellent</td>
                    </tr>
                </table>
                
                <h3>Pros & Cons</h3>
                
                <p><strong>Pros:</strong></p>
                <ul>
                    <li>Audio quality excellent untuk competitive gaming</li>
                    <li>Comfort tier atas untuk long sessions</li>
                    <li>Battery life terpanjang di kelasnya</li>
                    <li>Wireless latency imperceptible</li>
                    <li>THX Spatial Audio implementation bagus</li>
                    <li>Mic quality very good</li>
                    <li>Weight sangat ringan</li>
                </ul>
                
                <p><strong>Cons:</strong></p>
                <ul>
                    <li>Tidak ada Bluetooth (wireless via dongle only)</li>
                    <li>Plastik build meski sturdy, tidak premium feel seperti metal competitors</li>
                    <li>Synapse software kadang buggy</li>
                    <li>Earcups tidak swivel (bisa menyulitkan untuk hanging di neck)</li>
                </ul>
                
                <h3>Verdict</h3>
                <p>Razer BlackShark V2 Pro adalah <strong>go-to recommendation</strong> untuk competitive gamers yang serious. Value proposition excellent - performa tier atas dengan harga lebih reasonable dari kompetitor premium.</p>
                
                <p><strong>Pilih ini jika:</strong></p>
                <ul>
                    <li>Main competitive FPS dan butuh audio accuracy</li>
                    <li>Long gaming sessions (comfort priority)</li>
                    <li>Butuh battery life panjang</li>
                    <li>Budget sekitar 3 juta</li>
                </ul>
                
                <p><strong>Skip jika:</strong></p>
                <ul>
                    <li>Butuh Bluetooth untuk mobile usage</li>
                    <li>Prefer premium materials (metal, leather)</li>
                    <li>Purely single-player gamer (diminishing returns)</li>
                </ul>
                
                <p><strong>Rating Overall: 4.6/5</strong></p>
                <p><strong>Rating Gaming Performance: 5/5</strong></p>
                <p><strong>Rating Value: 5/5</strong></p>',
                'category' => 'Review',
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'views' => rand(100, 400)
            ],
            [
                'title' => '5 Mouse Gaming Terbaik 2024: Dari Budget hingga Pro Level',
                'slug' => '5-mouse-gaming-terbaik-2024',
                'excerpt' => 'Rekomendasi 5 mouse gaming terbaik di tahun 2024 untuk berbagai budget dan kebutuhan. Dari Logitech, Razer, hingga opsi budget-friendly yang tidak kalau performa.',
                'content' => '<h2>Top 5 Mouse Gaming 2024: Complete Guide</h2>
                <p>Memilih mouse gaming yang tepat crucial untuk performa, terutama di competitive gaming. Berikut 5 rekomendasi terbaik berdasarkan category berbeda.</p>
                
                <h3>1. Logitech G Pro X Superlight 2 - Best for Esports</h3>
                
                <h4>Spesifikasi:</h4>
                <ul>
                    <li><strong>Sensor:</strong> HERO 2 (32,000 DPI)</li>
                    <li><strong>Weight:</strong> 60 grams</li>
                    <li><strong>Battery:</strong> 95 jam (RGB off)</li>
                    <li><strong>Connectivity:</strong> Lightspeed Wireless 2.4GHz</li>
                    <li><strong>Polling Rate:</strong> 1000Hz (upgradeable ke 2000Hz via software)</li>
                </ul>
                
                <h4>Why It's Great:</h4>
                <p>G Pro X Superlight 2 adalah refined version dari already-legendary Superlight. Dengan weight hanya 60g, ini salah satu wireless mouse paling ringan. Shape ambidextrous dengan coating grip yang improved membuat ini favorite pro players di Valorant, CS2, dan Apex.</p>
                
                <p><strong>Sensor HERO 2</strong> memberikan tracking accuracy yang industry-leading dengan zero smoothing atau acceleration. LOD (lift-off distance) adjustable via software, crucial untuk low-sens players.</p>
                
                <p><strong>Best For:</strong> FPS competitive players, claw/fingertip grip</p>
                <p><strong>Harga:</strong> Rp 2.799.000</p>
                <p><strong>Rating: 5/5</strong></p>
                
                <hr>
                
                <h3>2. Razer Viper V3 Pro - Best All-Rounder</h3>
                
                <h4>Spesifikasi:</h4>
                <ul>
                    <li><strong>Sensor:</strong> Focus Pro 30K Optical (30,000 DPI)</li>
                    <li><strong>Weight:</strong> 54 grams</li>
                    <li><strong>Battery:</strong> 90 jam</li>
                    <li><strong>Connectivity:</strong> HyperSpeed Wireless</li>
                    <li><strong>Switches:</strong> Razer Optical Gen-3 (90M clicks rated)</li>
                </ul>
                
                <h4>Why It's Great:</h4>
                <p>Razer Viper V3 Pro adalah ultimate evolution dari Viper lineage. Dengan <strong>54 grams weight</strong>, ini officially mouse wireless paling ringan di market mainstream. Optical switches gen-3 memberikan click response yang instant dengan consistency tinggi.</p>
                
                <p>Shape low-profile symmetric cocok untuk berbagai grip styles. Sensor Focus Pro 30K memiliki <strong>Smart Tracking</strong> yang auto-calibrate untuk different mouse pad surfaces.</p>
                
                <p><strong>Best For:</strong> FPS & MOBA players, all grip styles</p>
                <p><strong>Harga:</strong> Rp 2.499.000</p>
                <p><strong>Rating: 4.8/5</strong></p>
                
                <hr>
                
                <h3>3. Logitech G502 X Plus - Best for Versatility</h3>
                
                <h4>Spesifikasi:</h4>
                <ul>
                    <li><strong>Sensor:</strong> HERO 25K</li>
                    <li><strong>Weight:</strong> 106 grams (tanpa weights)</li>
                    <li><strong>Battery:</strong> 120 jam</li>
                    <li><strong>Buttons:</strong> 13 programmable</li>
                    <li><strong>RGB:</strong> Lightsync RGB customizable</li>
                </ul>
                
                <h4>Why It's Great:</h4>
                <p>G502 X Plus adalah jack-of-all-trades mouse. Dengan 13 programmable buttons, ini exceptional untuk MMORPG, MOBA, atau gamers yang suka banyak macros. <strong>DPI-shift button</strong> memudahkan quick sensitivity changes on-the-fly.</p>
                
                <p>Meski lebih berat dari pure FPS mouse, weight distribution sangat balanced. Wireless charging via Powerplay mousepad adalah nice-to-have feature. Shape ergonomic dengan thumb rest comfortable untuk palm grip.</p>
                
                <p><strong>Best For:</strong> MOBA/MMO players, palm grip, multi-purpose gaming</p>
                <p><strong>Harga:</strong> Rp 2.199.000</p>
                <p><strong>Rating: 4.5/5</strong></p>
                
                <hr>
                
                <h3>4. Pulsar X2V2 - Best Budget Wireless</h3>
                
                <h4>Spesifikasi:</h4>
                <ul>
                    <li><strong>Sensor:</strong> PAW3395 (26,000 DPI)</li>
                    <li><strong>Weight:</strong> 55 grams (size medium)</li>
                    <li><strong>Battery:</strong> 70 jam</li>
                    <li><strong>Connectivity:</strong> 2.4GHz wireless + Bluetooth</li>
                    <li><strong>Polling Rate:</strong> 1000Hz (4000Hz di-planned via firmware)</li>
                </ul>
                
                <h4>Why It's Great:</h4>
                <p>Pulsar X2V2 adalah dark horse di scene mouse gaming. Brand relatively newer tapi quality exceptional. Dengan <strong>harga dibawah 2 juta</strong>, ini competitive dengan mice yang twice the price.</p>
                
                <p>PAW3395 sensor is top-tier, same family dengan sensor di mice premium. Build quality solid dengan coating anti-slip yang tahan lama. Shape berdasarkan Razer Viper clone tapi dengan slight modifications yang improves ergonomics.</p>
                
                <p><strong>Dual connectivity mode</strong> (2.4GHz & Bluetooth) memberikan flexibility - bisa switching antara gaming PC dan laptop dengan mudah.</p>
                
                <p><strong>Best For:</strong> Budget-conscious gamers, FPS players</p>
                <p><strong>Harga:</strong> Rp 1.699.000</p>
                <p><strong>Rating: 4.7/5 (value 5/5)</strong></p>
                
                <hr>
                
                <h3>5. Lamzu Atlantis Mini - Best for Small Hands / Fingertip Grip</h3>
                
                <h4>Spesifikasi:</h4>
                <ul>
                    <li><strong>Sensor:</strong> PAW3395</li>
                    <li><strong>Weight:</strong> 49 grams</li>
                    <li><strong>Battery:</strong> 80 jam</li>
                    <li><strong>Size:</strong> 114mm x 60mm x 36mm</li>
                    <li><strong>Switches:</strong> Huano Blue Shell Pink Dot (50M rated)</li>
                </ul>
                
                <h4>Why It's Great:</h4>
                <p>Lamzu Atlantis Mini adalah specialist mouse untuk <strong>small-handed players atau fingertip grip enthusiasts</strong>. Size compact tapi tidak sacrificing performance - PAW3395 sensor tetap top-tier.</p>
                
                <p>Dengan weight <strong>49 grams</strong>, ini ultra-light dalam category mini mouse. Shape unique dengan hump di belakang membantu palm support bahkan dengan size kecil. Build quality surprisingly good dengan minimal flex.</p>
                
                <p><strong>Best For:</strong> Small hands, fingertip grip, high-sens players</p>
                <p><strong>Harga:</strong> Rp 1.899.000</p>
                <p><strong>Rating: 4.6/5</strong></p>
                
                <hr>
                
                <h3>Comparison Table</h3>
                
                <table border="1" style="width:100%; border-collapse: collapse; margin: 20px 0;">
                    <tr style="background-color: #f0f0f0;">
                        <th style="padding: 10px;">Mouse</th>
                        <th style="padding: 10px;">Weight</th>
                        <th style="padding: 10px;">Sensor</th>
                        <th style="padding: 10px;">Battery</th>
                        <th style="padding: 10px;">Harga</th>
                        <th style="padding: 10px;">Best For</th>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">G Pro X SL 2</td>
                        <td style="padding: 10px;">60g</td>
                        <td style="padding: 10px;">HERO 2</td>
                        <td style="padding: 10px;">95h</td>
                        <td style="padding: 10px;">2.799K</td>
                        <td style="padding: 10px;">Pro FPS</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Viper V3 Pro</td>
                        <td style="padding: 10px;">54g</td>
                        <td style="padding: 10px;">Focus Pro</td>
                        <td style="padding: 10px;">90h</td>
                        <td style="padding: 10px;">2.499K</td>
                        <td style="padding: 10px;">All-round</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">G502 X Plus</td>
                        <td style="padding: 10px;">106g</td>
                        <td style="padding: 10px;">HERO 25K</td>
                        <td style="padding: 10px;">120h</td>
                        <td style="padding: 10px;">2.199K</td>
                        <td style="padding: 10px;">MOBA/MMO</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Pulsar X2V2</td>
                        <td style="padding: 10px;">55g</td>
                        <td style="padding: 10px;">PAW3395</td>
                        <td style="padding: 10px;">70h</td>
                        <td style="padding: 10px;">1.699K</td>
                        <td style="padding: 10px;">Budget</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Atlantis Mini</td>
                        <td style="padding: 10px;">49g</td>
                        <td style="padding: 10px;">PAW3395</td>
                        <td style="padding: 10px;">80h</td>
                        <td style="padding: 10px;">1.899K</td>
                        <td style="padding: 10px;">Small hands</td>
                    </tr>
                </table>
                
                <h3>Kesimpulan & Rekomendasi</h3>
                
                <p><strong>Jika budget unlimited:</strong> Logitech G Pro X Superlight 2 - proven di esports scene</p>
                
                <p><strong>Jika mencari value terbaik:</strong> Pulsar X2V2 - flagship performance dengan budget-friendly price</p>
                
                <p><strong>Jika main MOBA/MMO:</strong> Logitech G502 X Plus - versatility king</p>
                
                <p><strong>Jika hands kecil:</strong> Lamzu Atlantis Mini - specialist mouse yang excellent</p>
                
                <p><strong>Jika balanced antara price-performance:</strong> Razer Viper V3 Pro - lightest dengan features lengkap</p>
                
                <h3>Tips Memilih Mouse Gaming:</h3>
                <ol>
                    <li><strong>Hand Size:</strong> Measure hand size dulu (length palm to fingertip)</li>
                    <li><strong>Grip Style:</strong> Palm, claw, atau fingertip? Different shapes untuk different grips</li>
                    <li><strong>Sensitivity:</strong> Low-sens players butuh lightweight, high-sens bisa lebih flexible</li>
                    <li><strong>Game Type:</strong> FPS butuh lightweight simple, MOBA/MMO benefit dari extra buttons</li>
                    <li><strong>Budget:</strong> Mouse gaming good start dari 1.5 juta, premium di 2.5-3 juta range</li>
                </ol>
                
                <p>Semua mouse di list ini adalah excellent choices - pilihan akhir depends on personal preference dan specific use case. Happy gaming! 🎮🖱️</p>',
                'category' => 'Review',
                'status' => 'published',
                'published_at' => now(),
                'views' => rand(50, 200)
            ]
        ];

        foreach ($articles as $article) {
            $article['user_id'] = $admin->id;
            BlogPost::create($article);
        }
        
        $this->command->info('Blog posts seeded successfully!');
    }
}
