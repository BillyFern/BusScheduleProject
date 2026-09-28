import React from 'react';
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from '@/Components/TextInput';
import SelectInput from "@/Components/SelectInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function Create({ auth, buses, lokasis }) {
    const { data, setData, post, errors, reset } = useForm({
        bus_id: "",
        waktu_kedatangan: "",
        asal_id: "",
    });

    const onSubmit = (e) => {
        e.preventDefault();
        console.log(data)

        post(route("kedatangan.store"));
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Buat Jadwal Kedatangan Baru
                    </h2>
                </div>
            }
        >
            <Head title="Kedatangans" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <form
                            onSubmit={onSubmit}
                            className="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                            <div className="mt-4">
                                <InputLabel htmlFor="bus_id" value="Bus Berangkat" />
                                <SelectInput
                                    name="bus_id"
                                    id="bus_id"
                                    className='w-full mt-1'
                                    onChange={(e) => setData("bus_id", e.target.value)}
                                    value={data.bus_id}
                                >
                                    <option value="">Select Bus</option>
                                    {buses.map((bus) => (
                                        <option key={bus.id} value={bus.id}>{bus.kode_bus}</option>
                                    ))}
                                </SelectInput>
                                <InputError message={errors.bus_id} className="mt-2" />
                            </div>
                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="waktu_kedatangan"
                                    value="Jam Berangkat"
                                />
                                <TextInput
                                    type="time"
                                    id="waktu_kedatangan"
                                    name="waktu_kedatangan"
                                    value={data.waktu_kedatangan}
                                    className="block w-full mt-1"
                                    onChange={(e) => setData("waktu_kedatangan", e.target.value)}
                                />
                                <InputError message={errors.waktu_kedatangan} className="mt-2" />
                            </div>
                            <div className="mt-4">
                                <InputLabel htmlFor="asal_id" value="Lokasi Berangkat" />
                                <SelectInput
                                    name="asal_id"
                                    id="asal_id"
                                    className='w-full mt-1'
                                    onChange={(e) => setData("asal_id", e.target.value)}
                                    value={data.asal_id}
                                >
                                    <option value="">Select Lokasi</option>
                                    {lokasis.map((lokasi) => (
                                        <option key={lokasi.id} value={lokasi.id}>{lokasi.nama_lokasi}</option>
                                    ))}
                                </SelectInput>
                                <InputError message={errors.asal_id} className="mt-2" />
                            </div>
                            <div className="mt-4 text-right">
                                <Link
                                    href={route("kedatangan.index")}
                                    className="px-3 py-1 mr-2 text-gray-800 transition-all bg-gray-100 rounded shadow hover:bg-gray-200"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    className="px-3 py-1 text-white transition-all rounded shadow bg-emerald-500 hover:bg-emerald-600"
                                >
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
