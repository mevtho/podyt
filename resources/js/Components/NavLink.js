import React from 'react';
import { Link } from '@inertiajs/inertia-react';

export default function NavLink({ href, active, children }) {
    return (
        <Link
            href={href}
            className={
                active
                    ? 'text-white bg-secondary-700 text-white rounded-md py-2 px-3 text-sm font-medium transition duration-150 ease-in-out'
                    : 'text-white hover:bg-primary-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium transition duration-150 ease-in-out'
            }
        >
            {children}
        </Link>
    );
}
