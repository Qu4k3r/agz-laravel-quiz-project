import React, {useEffect} from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import {loginStyle} from '@/Styles/LoginStyle';
import {Head, Link, useForm} from '@inertiajs/inertia-react';

const {main} = loginStyle;

export default function Login({status, canResetPassword}) {
    const {data, setData, post, errors, reset} = useForm({
        email: '',
        password: '',
        remember: '',
    });

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    return (
        <main
            className="h-screen w-screen flex flex-col items-center bg-gray-400 ">
            <Head title="Log in"/>
            <section className="bg-gray-400 flex flex-col items-center h-full w-full m-20">
                <div className="flex flex-col items-center">
                    <h1 className="text-4xl font-bold text-gray-800">Log in</h1>
                </div>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        post(route('login.attempt'));
                    }}
                    className="flex flex-col items-center w-96">
                    <InputLabel label="Email" name="email" type="email" value={data.email} onChange={(e) => setData('email', e.target.value)}/>
                    <InputError error={errors.email}/>
                    <InputLabel label="Password" name="password" type="password" value={data.password} onChange={(e) => setData('password', e.target.value)}/>
                    <InputError error={errors.password}/>
                    <div className="flex items-center justify-between w-full">
                        <input type="text" />
                        <input type="text" />
                    </div>
                    <PrimaryButton className="w-full mt-4 bg-amber-600" processing={status === 'processing'}>Log in</PrimaryButton>
                </form>
            </section>
        </main>
    );
}
