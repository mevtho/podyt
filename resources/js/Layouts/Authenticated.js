import React from 'react';
import Navigation from "@/Components/Navigation";
import {usePage} from "@inertiajs/inertia-react";

export default function Authenticated({ header, children }) {
    const auth = usePage().props.auth;

    return (
        <div className="bg-primary-50 min-h-screen text-sm">
            <div className="bg-primary-600 border-b-8 border-secondary-500 pb-32">
                <Navigation auth={auth} />

                {header && (
                    <header className="py-10">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <h1 className="text-3xl font-bold text-white truncate">
                                {header}
                            </h1>
                        </div>
                    </header>
                )}
            </div>
            <main className="-mt-32 mb-16">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-primary-200">
                            {children}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    );
}
