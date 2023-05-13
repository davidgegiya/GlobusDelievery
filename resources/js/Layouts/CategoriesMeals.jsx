import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm, usePage} from '@inertiajs/react';
import { useEffect } from 'react';

export default function CategoriesMeals({auth, categories}) {
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
        if(data.meal_id!==''){
            switch (data.effect){
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

    const order_items = auth.order_items;
    return (
        categories.map((category) => {
            return (
                <div className="container" style={{backgroundColor: "palegoldenrod", marginBottom: "2em"}}>
                    <h1 style={{padding: "2em"}}>{category.name}</h1>
                    <div className="row">
                        {
                            category.meals.map((meal) => {
                                return(
                                <div className="col-sm-6 mx-auto">
                                    <div className="card text-center mx-auto"
                                         style={{padding: "20px", maxWidth: "400px", height: "30em", marginBottom: "3em"}}>
                                        <img src={ meal.image } className="card-img-top mx-auto" style={{width: "300px", maxHeight: '13em'}}
                                             alt="" />
                                        <div className="card-body">
                                            <h5 className="card-title">{meal.name}</h5>
                                            <h5 className="meal-weight">{meal.weight}</h5>
                                        </div>
                                        <div className="card-footer">
                                            <div className="row" style={{display: "flex", flexDirection: "row"}}>
                                                <div
                                                    className="delivery-price-group col mx-auto d-flex align-items-center justify-content-center">
                                                    {meal.price} ₽
                                                </div>
                                                <div
                                                    className="add-to-cart-group col d-flex align-items-center justify-content-center">
                                                    <div className="cart">
                                                        {
                                                            (
                                                                () => {
                                                                    let cond = false;
                                                                    let curr_item = null;
                                                                    const block = []
                                                                    if(order_items){
                                                                        order_items.forEach(order_item => {
                                                                            if(order_item.meal_id === meal.id){
                                                                                cond = true;
                                                                                curr_item = order_item;
                                                                            }
                                                                        })
                                                                    }

                                                                    if(!cond){
                                                                        block.push(<button className="btn btn-primary"
                                                                                           onClick={() => addToCart( meal.id )}>
                                                                            <i className="bi bi-basket"></i>
                                                                        </button>)
                                                                    }
                                                                    else {
                                                                        block.push(<div
                                                                            className="set-count-group row d-flex align-items-center justify-content-center"
                                                                            style={{padding: "0.5em"}}
                                                                            id={ meal.id }>
                                                                            <button className="btn btn-secondary col"
                                                                                    onClick={() => decrease( meal.id )}>
                                                                                <i className="bi bi-dash-square"></i>
                                                                            </button>
                                                                            <div className="container col">
                                                                                <span>{curr_item.count}</span>
                                                                            </div>
                                                                            <button className="btn btn-secondary col"
                                                                                    onClick={ () => increase( meal.id )}>
                                                                                <i className="bi bi-plus-square"></i>
                                                                            </button>
                                                                        </div>)
                                                                    }
                                                                    return block;
                                                                })()
                                                        }
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                );
                            })
                        }
                    </div>
                </div>
            )
        })
    )
}
