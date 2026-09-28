import '@/Pages/papan.css';
import { Head, router } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import { KEDATANGAN_STATUS_TEXT_MAP } from '@/constants';

function getDate() {
    const today = new Date();
    const month = today.getMonth() + 1;
    const year = today.getFullYear();
    const date = today.getDate();
    return `${month}/${date}/${year}`;
}

function getTimestampInSeconds() {
    return Math.floor(Date.now() / 1000)
}

function formatTimestamp(seconds) {
    const date = new Date(seconds * 1000);
    const hours = date.getHours();
    const minutes = date.getUTCMinutes();
    const secondsRemaining = date.getUTCSeconds();
    return `${hours}:${minutes}:${secondsRemaining}`;
}

export default function Kedatangan({ jadwals }) {

    const currentDate = useState(getDate());
    const [timestamp, setTimestamp] = useState(getTimestampInSeconds());

    useEffect(() => {
        const interval = setInterval(() => {
            setTimestamp(getTimestampInSeconds());
        }, 1000);
        return () => clearInterval(interval); // Cleanup interval on component unmount
    }, []);

    useEffect(() => {
        const interval = setInterval(() => {
            router.reload({ only: ['jadwals'] });
        }, 1000);

        return () => {
            clearInterval(interval);
        };
    }, []);

    useEffect(() => {
        let slideIndex = 0;

        function showSlides() {
            let i;
            const slides1 = document.querySelectorAll(".slideshow-container:nth-child(1) .mySlides");
            const slides2 = document.querySelectorAll(".slideshow-container:nth-child(2) .mySlides");
            const dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides1.length; i++) {
                slides1[i].style.display = "none";
                slides2[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides1.length) { slideIndex = 1 }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides1[slideIndex - 1].style.display = "block";
            slides2[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(showSlides, 2000); // Change image every 2 seconds
        }

        showSlides();

        return () => {
            // Clean up the interval when component unmounts
            clearTimeout(showSlides);
        };
    }, []);

    return (
        <div>
            <Head title="Papan" />

            <body>
                <div class="header">
                    <h1>Jadwal Kedatangan Bus PT Fajar Riau Lestari</h1>
                    <div style={{ textAlign: "center" }}>

                        <div className="slideshow-container">

                            <div className="mySlides fade">
                                <div className="numbertext">1 / 3</div>
                                <img src="https://agenbuspo.id/wp-content/uploads/2024/06/Layanan-Bus-Fajar-Riau-Wisata.webp" style={{ width: "100%" }} />
                            </div>

                            <div className="mySlides fade">
                                <div className="numbertext">2 / 3</div>
                                <img src="https://agenbuspo.id/wp-content/uploads/2024/06/Harga-Sewa-Bus-Fajar-Riau-Wisata.webp" style={{ width: "100%" }} />
                            </div>

                            <div className="mySlides fade">
                                <div className="numbertext">3 / 3</div>
                                <img src="https://i.ytimg.com/vi/d0Bdwiu0dRE/maxresdefault.jpg" style={{ width: "100%" }} />
                            </div>

                        </div>

                        <div className="slideshow-container">

                            <div className="mySlides fade">
                                <div className="numbertext">1 / 3</div>
                                <img src="https://www.saturental.com/media/uploads/2018/05/saturental-foto-bus-pariwisata-fajar-transport-interior-dalam-big-bus-59-seats-b.jpg" style={{ width: "100%" }} />
                            </div>

                            <div className="mySlides fade">
                                <div className="numbertext">2 / 3</div>
                                <img src="https://i.ytimg.com/vi/5HKeyZONsl4/maxresdefault.jpg" style={{ width: "100%" }} />
                            </div>

                            <div className="mySlides fade">
                                <div className="numbertext">3 / 3</div>
                                <img src="https://i.ytimg.com/vi/LlQbNShjWSU/maxresdefault.jpg" style={{ width: "100%" }} />
                            </div>

                        </div>

                    </div>
                    <br />
                    <div className="dot-container">
                        <span className="dot"></span>
                        <span className="dot"></span>
                        <span className="dot"></span>
                    </div>

                    <div class="date">
                        <h1>{currentDate} {formatTimestamp(timestamp)}</h1>
                    </div>
                </div>


                <div class="schedule">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Bus</th>
                                <th>Waktu Kedatangan</th>
                                <th>Asal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {jadwals.data.map((jadwal, index) => (
                                <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={jadwal.id}>
                                    <td>{index + 1}</td>
                                    <td className="px-3 py-2 text-nowrap">{jadwal.bus.kode_bus}</td>
                                    <td className="px-3 py-2">{jadwal.waktu_kedatangan}</td>
                                    <td className="px-3 py-2">{jadwal.asal.nama_lokasi}</td>
                                    <td className="px-3 py-2">{KEDATANGAN_STATUS_TEXT_MAP[jadwal.status]}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

            </body>
        </div>
    );
}
