import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import RestaurantList from "@/Layouts/RestaurantsList";
import SearchSort from "@/Pages/Partials/SearchSort";
import CategoriesMeals from "@/Layouts/CategoriesMeals";
import BasketItems from "@/Layouts/BasketItems";

export default function Cart({auth, items}) {
    const current_order = auth.current_order;
    return (
        <AuthenticatedLayout
            auth={auth}
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Корзина</h2>}
        >
            <Head title="Корзина"/>
            <BasketItems
                auth={auth}
            ></BasketItems>

        </AuthenticatedLayout>
    );
}
