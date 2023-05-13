import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm, usePage} from '@inertiajs/react';
import TextInput from "@/Components/TextInput";

export default function SearchSort({auth}) {
    const user = usePage().props.auth.user;
    const {data, setData, post, processing, errors, reset} = useForm({
        search: '',
        sort: 'name',
        sortType: 'ASC'
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('search'));
    };

    const actionSort = (e, n) => {
        setData('sort', n);
        submit(e);
    }

    let sort_type = [];

    data.sortType === 'ASC' ? sort_type.push(<i id="ic-sort-type" className="bi bi-sort-up"></i>)
        : sort_type.push(<i id="ic-sort-type" className="bi bi-sort-down"></i>);

    const actionSortType = (e, n) => {
        setData('sortType', n);
        sort_type = [];
        const className = "bi bi-sort-" + n === 'ASC' ? "up" : "down";
        sort_type.push('<i id="ic-sort-type" className={className}>')
        console.log(sort_type)
        submit(e);
    }

    return (
        <form method="post" onSubmit={submit} style={{maxWidth: '700px', marginTop: '3em'}} className="form-group text-center mx-auto">
            <div className="input-group">
                <span className="input-group-text" id="basic-addon1">Поиск...</span>
                <TextInput type="text" className="form-control" name="search" id="search" value={data.query}
                           onChange={(e) => {setData('search', e.target.value); submit(e)}}
                />
                <button className="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false"><i className="bi bi-filter"></i></button>
                <ul className="dropdown-menu dropdown-menu-end">
                    <li>
                        <button className="dropdown-item" type="button" onClick={(e) => {actionSort(e, 'name')}}>Имени</button>
                    </li>
                    <li>
                        <button className="dropdown-item" type="button" onClick={(e) => {actionSort(e, 'rating')}}>Ценовой политике
                        </button>
                    </li>
                    <li>
                        <button className="dropdown-item" type="button"
                                onClick={(e) => {actionSort(e, 'delivery_price')}}>Стоимости
                            доставки
                        </button>
                    </li>
                    <li>
                        <button className="dropdown-item" type="button"
                                onClick={(e) => {actionSort(e, 'delivery_time')}}>Времени доставки
                        </button>
                    </li>
                </ul>
                <button className="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">{sort_type}</button>
                <ul className="dropdown-menu dropdown-menu-end">
                    <li>
                        <button className="dropdown-item" type="button" onClick={(e) => {actionSortType(e, 'ASC')}}>По
                            возрастанию
                        </button>
                    </li>
                    <li>
                        <button className="dropdown-item" type="button" onClick={(e) => {actionSortType(e, 'DESC')}}>По
                            убыванию
                        </button>
                    </li>
                </ul>
            </div>
            <input type="hidden" id="sort" value="name" name="sort"/>
            <input type="hidden" id="sort-type" value="ASC" name="sort-type"/>
        </form>
    );
}
