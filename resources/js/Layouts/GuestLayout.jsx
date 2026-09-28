import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import mainLogo from '@/Pages/logo.png'

export default function Guest({ children }) {
    return (
        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-orange-400 dark:bg-gray-900">

            <div className='w-full sm:max-w-md mt-6 px-6 py-4 bg-white rounded-lg'>
                <div className="flex justify-center">
                    <Link href="/">
                        <img src={mainLogo} alt="logo" className='rounded w-64 ' />
                    </Link>
                </div>

                <div className="overflow-hidden ">
                    {children}
                </div>
            </div>
        </div>
    );
}
