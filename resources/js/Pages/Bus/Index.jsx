import React from 'react';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import TableHeading from '@/Components/TableHeading';
import Pagination from "@/Components/Pagination";
import TextInput from "@/Components/TextInput";
import { Head, Link, router } from "@inertiajs/react";

export default function Index({ auth, buses, queryParams = null, success }) {
    queryParams = queryParams || {};

    const searchFieldChanged = (name, value) => {
        if (value) {
            queryParams[name] = value;
        } else {
            delete queryParams[name];
        }
        router.get(route('bus.index'), queryParams);
    };

    const onKeyPress = (name, e) => {
        if (e.key !== 'Enter') return;
        searchFieldChanged(name, e.target.value);
    };

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
        router.get(route('bus.index'), queryParams);
    };

    const deleteBus = (bus) => {
        if (!window.confirm("Apakah anda yakin ingin menghapus Bus?")){
            return;
        }
        router.delete(route("bus.destroy", bus.id));
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="text-xl font-semibold leading-tight 
                text-gray-800 dark:text-gray-200">
                        Daftar Bus
                    </h2>
                    <Link
                        href={route("bus.create")}
                        className="bg-emerald-500 py-1 px-3 text-white rounded
                shadow transition-all hover:bg-emerald-600">
                        Add New
                    </Link>
                </div>
            }
        >
            <Head title="Buses" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {success && (
                        <div className="bg-emerald-500 py-2 px-4 text-white rounded mb-4">
                            {success}
                        </div>
                    )}
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="overflow-auto">
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
                                                name="kode_bus"
                                                sort_field={queryParams.sort_field}
                                                sort_direction={queryParams.sort_direction}
                                                sortChanged={sortChanged}
                                            >
                                                Kode Bus
                                            </TableHeading>
                                            <th className="px-3 py-3 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <thead className="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-3"></th>
                                            <th className="px-3 py-3">
                                                <TextInput
                                                    className="w-full"
                                                    defaultValue={queryParams.name}
                                                    placeholder="Kode Bus"
                                                    onBlur={e => searchFieldChanged('kode_bus', e.target.value)}
                                                    onKeyPress={e => onKeyPress('kode_bus', e)}
                                                />
                                            </th>
                                            <th className="px-3 py-3"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {buses.data.map((bus) => (
                                            <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={bus.id}>
                                                <td className="px-3 py-2">{bus.id}</td>
                                                <td className="px-3 py-2">{bus.kode_bus}</td>
                                                <td className="px-3 py-2 text-right">
                                                    <Link
                                                        href={route("bus.edit", bus.id)}
                                                        className="mx-1 font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                                    >
                                                        Edit
                                                    </Link>
                                                    <button
                                                        onClick={(e) => deleteBus(bus)}
                                                        className="mx-1 font-medium text-red-600 dark:text-red-500 hover:underline"
                                                    >
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                                <Pagination links={buses.meta.links} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
