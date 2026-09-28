import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import SelectInput from "@/Components/SelectInput";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { JADWAL_STATUS_TEXT_MAP } from "@/constants";

export default function Create({ auth, kedatangan, buses, lokasis }) {
  const { data, setData, post, errors, reset } = useForm({
    bus_id: kedatangan.bus_id || "",
    waktu_kedatangan: kedatangan.waktu_kedatangan || "",
    asal_id: kedatangan.asal_id || "",
    status: kedatangan.status !== undefined ? kedatangan.status : "",
    _method: "PUT",
  });

  const onSubmit = (e) => {
    e.preventDefault();
    post(route("kedatangan.update", kedatangan.id));
  };

  console.log("Initial form data:", data);
  console.log("Buses:", buses);
  console.log("Lokasis:", lokasis);

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit kedatangan Kedatangan "{kedatangan.id}"
          </h2>
        </div>
      }
    >
      <Head title="Kedatangans" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <form
              onSubmit={onSubmit}
              className="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg"
            >
              <div className="mt-4">
                <InputLabel htmlFor="bus_id" value="Bus Berangkat" />
                <SelectInput
                  name="bus_id"
                  id="bus_id"
                  className="w-full mt-1"
                  onChange={(e) => setData("bus_id", e.target.value)}
                  value={data.bus_id}
                >
                  <option value="">Select Bus</option>
                  {buses.map((bus) => (
                    <option key={bus.id} value={bus.id}>
                      {bus.kode_bus}
                    </option>
                  ))}
                </SelectInput>
                <InputError message={errors.bus_id} className="mt-2" />
              </div>
              <div className="mt-4">
                <InputLabel htmlFor="waktu_kedatangan" value="Jam Berangkat" />
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
                <InputLabel htmlFor="status" value="Status" />
                <SelectInput
                  name="status"
                  id="status"
                  className="w-full mt-1"
                  onChange={(e) => setData("status", e.target.value)}
                  value={data.status}
                >
                  <option value="">Ubah Status</option>
                  {Object.keys(JADWAL_STATUS_TEXT_MAP).map((key) => (
                    <option key={key} value={key}>
                      {JADWAL_STATUS_TEXT_MAP[key]}
                    </option>
                  ))}
                </SelectInput>
                <InputError message={errors.status} className="mt-2" />
              </div>
              <div className="mt-4">
                <InputLabel htmlFor="asal_id" value="Lokasi Berangkat" />
                <SelectInput
                  name="asal_id"
                  id="asal_id"
                  className="w-full mt-1"
                  onChange={(e) => setData("asal_id", e.target.value)}
                  value={data.asal_id}
                >
                  <option value="">Select Lokasi</option>
                  {lokasis.map((lokasi) => (
                    <option key={lokasi.id} value={lokasi.id}>
                      {lokasi.nama_lokasi}
                    </option>
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
