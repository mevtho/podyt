import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import {Head} from '@inertiajs/inertia-react';

export default function Dashboard(props) {
    return (
        <Authenticated
            header="Dashboard"
        >
            <Head title="Dashboard" />

            You're logged in!
        </Authenticated>
    );
}
