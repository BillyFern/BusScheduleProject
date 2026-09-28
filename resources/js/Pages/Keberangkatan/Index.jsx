import React from 'react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import Pagination from "@/Components/Pagination";
import TableHeading from '@/Components/TableHeading';
import { JADWAL_STATUS_TEXT_MAP } from '@/constants';

export default function Index({ auth, keberangkatans, queryParams = null, success }) {
    queryParams = queryParams || {};

    const sortChanged = (name) => {
        if (name == queryParams.sort_field) {
            if (queryParams.sort_direction === 'asc') {
                queryParams.sort_direction = 'desc';
            } else {
                queryParams.sort_direction = 'asc';
            }
        } else {
            queryParams.sort_field = name;
            queryParams.sort_direction = 'asc';
        }
        router.get(route('keberangkatan.index'), queryParams);
    };

    const deleteJadwal = (keberangkatan) => {
        if (!window.confirm("Apakah anda yakin ingin menghapus keberangkatan?")) {
            return;
        }
        router.delete(route("keberangkatan.destroy", keberangkatan.id));
    }

    const resetJadwal = () => {
        if (!window.confirm("Apakah anda yakin ingin reset status keberangkatan? Ini akan mengubah semua status menjadi menunggu")) {
            return;
        }
        router.get(route("resetJadwal"));
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Daftar Jadwal Keberangkatan
                    </h2>

                    <button
                        onClick={(e) => resetJadwal()}
                        className="bg-blue-500 py-1 px-3 text-white rounded
                shadow transition-all hover:bg-blue-600"
                    >
                        Reset Status Jadwal
                    </button>
                    <Link
                        href={route("keberangkatan.create")}
                        className="bg-emerald-500 py-1 px-3 text-white rounded
                shadow transition-all hover:bg-emerald-600">
                        Add New
                    </Link>
                </div>
            }
        >
            <Head title="Jadwals" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {success && (
                        <div className="bg-emerald-500 py-2 px-4 text-white rounded mb-4">
                            {success}
                        </div>
                    )}
                    <div className="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <table className="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                                <thead className="text-xs text-gray-700 uppercase border-b-2 border-gray-500 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr className="text-nowrap">
                                        <TableHeading
                                            name="id"
                                            sort_field={queryParams.sort_field}
                                            sort_direction={queryParams.sort_direction}
                                            sortChanged={sortChanged}
                                        >
                                            ID
                                        </TableHeading>
                                        <TableHeading
                                            name="bus_id"
                                            sort_field={queryParams.sort_field}
                                            sort_direction={queryParams.sort_direction}
                                            sortChanged={sortChanged}
                                        >
                                            Kode Bus
                                        </TableHeading>
                                        <TableHeading
                                            name="waktu_keberangkatan"
                                            sort_field={queryParams.sort_field}
                                            sort_direction={queryParams.sort_direction}
                                            sortChanged={sortChanged}
                                        >
                                            Waktu Keberangkatan
                                        </TableHeading>
                                        <TableHeading
                                            name="tujuan_id"
                                            sort_field={queryParams.sort_field}
                                            sort_direction={queryParams.sort_direction}
                                            sortChanged={sortChanged}
                                        >
                                            Tujuan
                                        </TableHeading>
                                        <TableHeading
                                            name="status"
                                            sort_field={queryParams.sort_field}
                                            sort_direction={queryParams.sort_direction}
                                            sortChanged={sortChanged}
                                        >
                                            Status
                                        </TableHeading>
                                        <th className="px-3 py-3 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {keberangkatans.data.map((keberangkatan) => (
                                        <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={keberangkatan.id}>
                                            <td className="px-3 py-2">{keberangkatan.id}</td>
                                            <td className="px-3 py-2 text-nowrap">{keberangkatan.bus.kode_bus}</td>
                                            <td className="px-3 py-2">{keberangkatan.waktu_keberangkatan}</td>
                                            <td className="px-3 py-2">{keberangkatan.tujuan.nama_lokasi}</td>
                                            <td className="px-3 py-2">{JADWAL_STATUS_TEXT_MAP[keberangkatan.status]}</td>
                                            <td className="px-3 py-2">
                                                <Link
                                                    href={route("keberangkatan.edit", keberangkatan.id)}
                                                    className="mx-1 font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                >
                                                    Edit
                                                </Link>
                                                <button
                                                    onClick={(e) => deleteJadwal(keberangkatan)}
                                                    className="mx-1 font-medium text-red-600 dark:text-red-500 hover:underline"
                                                >
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                            <Pagination links={keberangkatans.meta.links} />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
