import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm, usePage} from '@inertiajs/react';

export default function RestaurantList({auth, restaurants}) {
    const user = usePage().props.auth.user;
    const {data, setData, post, processing, errors, reset} = useForm({});

    const submit = (e) => {
        e.preventDefault();

    };

    return (
        <div className="row" id="inc-temp" style={{marginTop: '1em'}}>
            {
                restaurants.length ? restaurants.map((restaurant) => {
                    return (
                        <div className="col-sm-6 mx-auto bg-app-burger">
                            <a href={route('restContent', restaurant.name)}
                               className="card text-center mx-auto"
                               style={{
                                   padding: '20px',
                                   maxWidth: '400px',
                                   marginBottom: '3em',
                                   textDecoration: 'none',
                                   color: 'black'
                               }}>
                                <img src={restaurant.image} className="card-img-top mx-auto"
                                     style={{width: '300px', maxHeight: '13em'}} alt=""/>
                                <div className="card-body">
                                    <h5 className="card-title">{restaurant.name}</h5>
                                </div>
                                <div className="card-footer">
                                    <div className="row" style={{display: 'flex', flexDirection: 'row'}}>
                                        <div className="rating-group col-3">
                                            {
                                                (
                                                    () => {
                                                        const pricing = [];
                                                        for (let i = 0; i < restaurant.rating; i++) {
                                                            pricing.push(<span style={{color: "orange"}}>₽</span>);
                                                        }

                                                        return pricing;
                                                    }
                                                )()
                                            }
                                        </div>
                                        <div className="delivery-price-group col-4">
                                            <i className="bi bi-currency-dollar"
                                               style={{color: 'green', marginRight: '5px'}}></i>
                                            От {restaurant.delivery_price} ₽
                                        </div>
                                        <div className="delivery-time-group col-5">
                                            <i className="bi bi-truck" style={{marginRight: '5px'}}></i>
                                            {restaurant.delivery_time}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    );
                }) : (
                    <div className="card text-center mx-auto"
                         style={{padding: '20px', maxWidth: '400px', marginBottom: '3em'}}>
                        <h1>Извините, ничего не найдено :(</h1>
                    </div>
                )
            }
            }
        </div>
    );
}
