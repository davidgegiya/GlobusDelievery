import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import RestaurantList from "@/Layouts/RestaurantsList";
import SearchSort from "@/Pages/Partials/SearchSort";

export default function Restaurants({ auth, restaurants }) {
    const current_order = auth.current_order;
    return (
        <AuthenticatedLayout
            auth={auth}
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Рестораны</h2>}
        >
            <Head title="Рестораны" />
            <SearchSort></SearchSort>
            <RestaurantList
                restaurants={restaurants}
            ></RestaurantList>
        </AuthenticatedLayout>
    );
}
