import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import RestaurantList from "@/Layouts/RestaurantsList";
import SearchSort from "@/Pages/Partials/SearchSort";
import CategoriesMeals from "@/Layouts/CategoriesMeals";
import BasketItems from "@/Layouts/BasketItems";

export default function OrdersList({auth, orders}) {
    const current_order = auth.current_order;
    console.log(orders)
    return (
        <AuthenticatedLayout
            auth={auth}
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Мои заказы</h2>}
        >
            <Head title="Мои заказы"/>
            {
                orders.map(order => {
                    return(
                        <div className="col-sm-6" id={ order.id }>
                            <div className="card text-center mx-auto"
                                 style={{padding: "20px", maxWidth: "400px", marginBottom: "3em"}}>
                                <a className="card-link" href={ route('viewOrder', order.id) }>
                                    <img src={ order.order_items[0].meal.image }
                                         className="card-img-top mx-auto" style={{width: "300px"}}
                                         alt="" />
                                        <div className="card-body">
                                            <h5 className="card-title">Заказ от {order.updated_at}</h5>
                                        </div>
                                </a>
                                <div className="card-footer">
                                    <div className="row" style={{display: "flex", flexDirection: "row"}}>
                                        <div className="price-total-group col-5">
                                            <span id={ order.id }> На сумму: {order.total_price} ₽ </span>
                                        </div>
                                        <div className="status-group col-5">
                                            <span id={ order.id }> Статус: {order.status} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    );
                })
            }

        </AuthenticatedLayout>
    );
}
