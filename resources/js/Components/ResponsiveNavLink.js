import React from 'react';
import { Link } from '@inertiajs/inertia-react';

export default function ResponsiveNavLink({ method = 'get', as = 'a', href, active = false, children }) {
    return (
        <Link
            method={method}
            as={as}
            href={href}
            className={`w-full flex items-start pl-3 pr-4 py-2 border-l-4 ${
                active
                    ? 'border-secondary-400 text-secondary-700 bg-secondary-50 focus:outline-none focus:text-secondary-800 focus:bg-secondary-100 focus:border-secondary-700'
                    : 'border-transparent text-primary-600 hover:text-primary-800 hover:bg-primary-50 hover:border-primary-300'
            } text-base font-medium focus:outline-none transition duration-150 ease-in-out`}
        >
            {children}
        </Link>
    );
}
