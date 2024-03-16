import React, { useEffect } from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import {loginStyle} from '@/Styles/LoginStyle';
import { Head, Link, useForm } from '@inertiajs/inertia-react';

const {main } = loginStyle;

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, errors, reset } = useForm({
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
        <main className={main}>
            <Head title="Log in" />
            <h1>Bem-vindos a escola</h1>
            <h1>Horizon Point</h1>

        </main>
    );
}
