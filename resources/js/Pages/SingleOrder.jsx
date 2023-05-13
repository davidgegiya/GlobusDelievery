import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import RestaurantList from "@/Layouts/RestaurantsList";
import SearchSort from "@/Pages/Partials/SearchSort";
import CategoriesMeals from "@/Layouts/CategoriesMeals";
import BasketItems from "@/Layouts/BasketItems";

export default function SingleOrder({auth, order_items, order}) {
    const current_order = auth.current_order;
    return (
        <AuthenticatedLayout
            auth={auth}
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Заказ №</h2>}
        >
            <Head title="Заказ №"/>
            <h1 style={{backgroundColor: "lightgray", marginBottom: "1em"}}>Заказ от { order.updated_at }</h1>
            <h3 style={{backgroundColor: "lightgray", marginBottom: "1em"}} id="total-price"> Заказ на
                на { order.total_price } ₽</h3>

            {
                order_items.map(order_item => {
                    return(
                        <div className="col-sm-6" id={order_item.id}>
                            <div className="card text-center mx-auto"
                                 style={{padding: "20px", maxWidth: "400px", marginBottom: "3em"}}>
                                <div className="btn-group"
                                     style={{display: "flex", justifyContent: "end", marginBottom: "1em"}}>
                                </div>
                                <a className="card-link"
                                   href={route('restContent', order_item.meal.restaurant_name)}>
                                    <img src={order_item.meal.image} className="card-img-top mx-auto"
                                         style={{width: "300px"}}
                                         alt=""/>
                                    <div className="card-body">
                                        <h5 className="card-title">{order_item.meal.name}</h5>
                                    </div>
                                </a>
                                <div className="card-footer">
                                    <div className="row" style={{display: "flex", flexDirection: "row"}}>
                                        <div className="count-group col-3">
                                            <span id={ order_item.id }>X {order_item.count}</span>
                                        </div>
                                        <div className="price-per-one-group col-4">
                                            <span> {order_item.meal.price} ₽ </span>
                                        </div>
                                        <div className="price-total-group col-5">
                                                <span id={order_item.id}> Итого: {
                                                    (
                                                        () => {
                                                            return order_item.meal.price * order_item.count;
                                                        }
                                                    )()
                                                } ₽ </span>
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
