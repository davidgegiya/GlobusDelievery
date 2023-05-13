import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import RestaurantList from "@/Layouts/RestaurantsList";
import SearchSort from "@/Pages/Partials/SearchSort";
import CategoriesMeals from "@/Layouts/CategoriesMeals";

export default function RestContent({auth, categories, meals, rest_name}) {
    const current_order = auth.current_order;
    return (
        <AuthenticatedLayout
            auth={auth}
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">{rest_name}</h2>}
        >
            <Head title={rest_name}/>
            <CategoriesMeals
                auth={auth}
                categories={categories}
                meals={meals}
            ></CategoriesMeals>

        </AuthenticatedLayout>
    );
}
