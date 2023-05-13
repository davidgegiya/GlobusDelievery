import { useRef, useState } from 'react';
import DangerButton from '@/Components/DangerButton';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import Modal from '@/Components/Modal';
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';
import { useForm } from '@inertiajs/react';

export default function DeleteUserForm({ className = '' }) {
    const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
    const passwordInput = useRef();

    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        errors,
    } = useForm({
        password: '',
    });

    const confirmUserDeletion = () => {
        setConfirmingUserDeletion(true);
    };

    const deleteUser = (e) => {
        e.preventDefault();

        destroy(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.current.focus(),
            onFinish: () => reset(),
        });
    };

    const closeModal = () => {
        setConfirmingUserDeletion(false);

        reset();
    };

    return (
        <section className={`className Form space-y-6 ${className}`}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">Удалить аккаунт</h2>

                <p className="mt-1 text-sm text-gray-600">
                    После удаления вашего аккаунта все его ресурсы и данные будут безвозвратно удалены. До
                    удаления аккаунта, загрузите любые данные или информацию, которые вы хотите сохранить.
                </p>
            </header>


            <DangerButton  onClick={confirmUserDeletion}>Удалить аккаунт</DangerButton>

            <Modal show={confirmingUserDeletion} onClose={closeModal}>
                <form onSubmit={deleteUser} className=" p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        Вы уверены, что хотите удалить аккаунт?
                    </h2>

                    <p className="mt-1 text-sm text-gray-600">
                        После удаления вашего аккаунта все его ресурсы и данные будут безвозвратно удалены. До
                        удаления аккаунта, загрузите любые данные или информацию, которые вы хотите сохранить.
                    </p>

                    <div className="mt-6">
                        <InputLabel htmlFor="password2" value="Для удаления аккаунта введите текущий пароль" className="formTextInp sr-only" />

                        <TextInput
                            id="password2"
                            type="password"
                            name="password"
                            ref={passwordInput}
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            className="formTextInp mt-1 block w-3/4"
                            isFocused
                            placeholder="Для удаления аккаунта введите текущий пароль"
                        />

                        <InputError message={errors.password} className="formTextInp mt-2" />
                    </div>

                    <div className="mt-6 flex justify-end">
                        <SecondaryButton onClick={closeModal}>Отмена</SecondaryButton>

                        <DangerButton className="ml-3" disabled={processing}>
                            Удалить аккаунт
                        </DangerButton>
                    </div>
                </form>
            </Modal>
        </section>
    );
}
