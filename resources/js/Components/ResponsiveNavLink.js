import React from 'react';
import {Link} from '@inertiajs/inertia-react';

export default function ResponsiveNavLink({ method = 'get', as = 'a', href, active = false, children }) {
    return (
        <Link
            method={method}
            as={as}
            href={href}
            className={`w-full flex items-start pl-3 pr-4 py-2 border-l-4 ${
                active
                    ? 'border-white text-white bg-primary-500 hover:bg-primary-400 hover:border-white focus:outline-none focus:text-white focus:bg-primary-400 focus:border-white'
                    : 'border-transparent text-white hover:text-white hover:bg-primary-400 hover:border-white'
            } text-base font-medium focus:outline-none transition duration-150 ease-in-out`}
        >
            {children}
        </Link>
    );
}
