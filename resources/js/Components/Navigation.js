import React, {useState} from "react";
import ApplicationLogo from "@/Components/ApplicationLogo";
import NavLink from "@/Components/NavLink";
import Dropdown from "@/Components/Dropdown";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink";
import {ChevronDownIcon} from "@heroicons/react/outline";

export default function Navigation({auth}) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

    return <nav className="border-b border-primary-400">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex justify-between h-16">
                <div className="px-2 flex items-center lg:px-0">
                    <div className="flex-shrink-0 flex items-center">
                        <a href={route('dashboard')}>
                            <ApplicationLogo className="block h-9 w-auto text-secondary-500"/>
                        </a>
                    </div>

                    <div className="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <div className="flex space-x-4">
                            <NavLink href={route('feed.index')} active={route().current('feed.*')}>
                                Feeds
                            </NavLink>
                        </div>
                    </div>
                </div>

                <div className="hidden sm:flex sm:items-center sm:ml-6">
                    <div className="ml-3 relative">
                        <Dropdown>
                            <Dropdown.Trigger>
                                <span className="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:bg-primary-400 focus:outline-none transition ease-in-out duration-150"
                                    >
                                        {auth.user.name}

                                        <ChevronDownIcon className="ml-2 -mr-0.5 h-4 w-4"/>
                                    </button>
                                </span>
                            </Dropdown.Trigger>

                            <Dropdown.Content>
                                <Dropdown.Link href={route('logout')} method="post" as="button">
                                    Log Out
                                </Dropdown.Link>
                            </Dropdown.Content>
                        </Dropdown>
                    </div>
                </div>

                <div className="-mr-2 flex items-center sm:hidden">
                    <button
                        onClick={() => setShowingNavigationDropdown((previousState) => !previousState)}
                        className="inline-flex items-center justify-center p-2 rounded-md text-primary-400 hover:text-white hover:bg-primary-400 focus:outline-none focus:bg-primary-400 focus:text-white transition duration-150 ease-in-out"
                    >
                        <svg className="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                className={!showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                className={showingNavigationDropdown ? 'inline-flex' : 'hidden'}
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div className={(showingNavigationDropdown ? 'block' : 'hidden') + ' sm:hidden'}>
            <div className="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink
                    href={route('feed.index')}
                    active={route().current('feed.*')}
                >
                    Feeds
                </ResponsiveNavLink>
            </div>

            <div className="pt-4 pb-1 border-t border-primary-400">
                <div className="mt-3 space-y-1">
                    <ResponsiveNavLink method="post" href={route('logout')} as="button">
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>
}
