import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm, usePage} from '@inertiajs/react';
import {useEffect} from 'react';

export default function BasketItems({auth}) {
    const user = usePage().props.auth.user;
    const current_order = auth.current_order;
    const {data, setData, post, processing, errors, reset} = useForm({
        meal_id: '',
        effect: 0,
        total_price: current_order ? current_order.total_price : 0,
        dummy: 0
    });

    function generateRandomDecimalString() {
        return (Math.random() * 100).toFixed(10);
    }

    useEffect(() => {
        if (data.meal_id !== '') {
            switch (data.effect) {
                case 0:
                    break;
                case 1:
                    submit('addToCart');
                    break;
                case 2:
                    submit('decrease');
                    break;
                case 3:
                    submit('increase');
                    break;
                case 4:
                    submit('removeFromCart');
                    break;
            }
        }
    }, [data.meal_id, data.effect, data.dummy]);


    const submit = (route_) => {
        post(route(route_), {
            onSuccess: () => {
                console.log('success')
                // this.$inertia.update()
            }
        });
    };

    const addToCart = (id) => {
        setData({meal_id: id, effect: 1, dummy: generateRandomDecimalString()})
    }
    const decrease = (id) => {
        setData({meal_id: id, effect: 2, dummy: generateRandomDecimalString()})
    }
    const increase = (id) => {
        setData({meal_id: id, effect: 3, dummy: generateRandomDecimalString()})
    }

    const deleteFromDB = (id) => {
        setData({meal_id: id, effect: 4, dummy: generateRandomDecimalString()})
    }

    const order_items = auth.order_items;
    if (!order_items) {
        return (
            <h1 style={{color: "white"}}>В корзине ничего нет :(</h1>
        );
    } else {
        return (
            <div>
                <h3 style={{backgroundColor: "lightgray", marginBottom: "1em"}} id="total-price"> В корзине товаров
                    на {current_order.total_price} ₽</h3>
                {
                    order_items.map(order_item => {
                        return (
                            <div className="col-sm-6" id={order_item.id}>
                                <div className="card text-center mx-auto"
                                     style={{padding: "20px", maxWidth: "400px", marginBottom: "3em"}}>
                                    <div className="btn-group"
                                         style={{display: "flex", justifyContent: "end", marginBottom: "1em"}}>
                                        <button className="btn btn-danger" style={{maxWidth: "3em"}}
                                                onClick={() => deleteFromDB(order_item.id)}><i
                                            className="bi bi-trash3-fill"></i>
                                        </button>
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
                                    <div
                                        className="set-count-group row d-flex align-items-center justify-content-center"
                                        style={{padding: "0.5em"}} id="{{ $order_item->meal->id }}">
                                        <button className="btn btn-secondary col"
                                                onClick={() => decrease(order_item.meal_id)}>
                                            <i className="bi bi-dash-square"></i>
                                        </button>
                                        <div className="container col">
                                            <span>{order_item.count}</span>
                                        </div>
                                        <button className="btn btn-secondary col"
                                                onClick={() => increase(order_item.meal_id)}>
                                            <i className="bi bi-plus-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        );
                    })
                }
                <a href={route('placeOrder')}>
                    <button className="btn btn-success" style={{marginBottom: "2em"}}>Оформить заказ</button>
                </a>
            </div>
        );
    }
}
