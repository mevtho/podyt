import React, {useState} from "react";
import {Link} from "@inertiajs/inertia-react";
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
                        <a href="/">
                            <ApplicationLogo className="block h-9 w-auto text-primary-500"/>
                        </a>
                    </div>

                    <div className="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <div className="flex space-x-4">
                            <NavLink href={route('feed.index')} active={route().current('feed.*')}>
                                Your feeds
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
                <div className="px-4">
                    <div className="font-medium text-base text-white">{auth.user.name}</div>
                    <div className="font-medium text-sm text-primary-50">{auth.user.email}</div>
                </div>

                <div className="mt-3 space-y-1">
                    <ResponsiveNavLink method="post" href={route('logout')} as="button">
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>


    // return <Disclosure as="nav" className="bg-primary-600 border-b border-primary-300 border-opacity-25 lg:border-none">
    //     {({open}) => (
    //         <>
    //             <div className="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
    //                 <div
    //                     className="relative h-16 flex items-center justify-between lg:border-b lg:border-primary-400 lg:border-opacity-25">
    //                     <div className="px-2 flex items-center lg:px-0">
    //                         <div className="flex-shrink-0">
    //                             <Link href="/">
    //                                 <ApplicationLogo className="block h-9 w-auto text-primary-500"/>
    //                             </Link>
    //                         </div>
    //                         <div className="hidden lg:block lg:ml-10">
    //                             <div className="flex space-x-4">
    //                                 <NavLink href={route('feed.index')} active={route().current('feed.index')}>
    //                                     Your Feeds
    //                                 </NavLink>
    //                             </div>
    //                         </div>
    //                     </div>
    //                     <div className="flex lg:hidden">
    //                         {/* Mobile menu button */}
    //                         <Disclosure.Button
    //                             className="bg-primary-600 p-2 rounded-md inline-flex items-center justify-center text-primary-200 hover:text-white hover:bg-primary-500 hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-primary-600 focus:ring-white">
    //                             <span className="sr-only">Open main menu</span>
    //                             {open ? (
    //                                 <XIcon className="block h-6 w-6" aria-hidden="true"/>
    //                             ) : (
    //                                 <MenuIcon className="block h-6 w-6" aria-hidden="true"/>
    //                             )}
    //                         </Disclosure.Button>
    //                     </div>
    //                     <div className="hidden lg:block lg:ml-4">
    //                         <div className="flex items-center">
    //                             {/* Profile dropdown */}
    //                             <Menu as="div" className="ml-3 relative flex-shrink-0">
    //                                 <div>
    //                                     <Menu.Button
    //                                         className="bg-primary-600 rounded-full flex text-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-primary-600 focus:ring-white">
    //                                         <span className="sr-only">Open user menu</span>
    //                                         {auth.user.name}
    //
    //                                         <ChevronDownIcon className="ml-2 -mr-0.5 h-4 w-4" />
    //                                     </Menu.Button>
    //                                 </div>
    //                                 <Transition
    //                                     as={Fragment}
    //                                     enter="transition ease-out duration-100"
    //                                     enterFrom="transform opacity-0 scale-95"
    //                                     enterTo="transform opacity-100 scale-100"
    //                                     leave="transition ease-in duration-75"
    //                                     leaveFrom="transform opacity-100 scale-100"
    //                                     leaveTo="transform opacity-0 scale-95"
    //                                 >
    //                                     <Menu.Items
    //                                         className="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
    //                                         <Menu.Item>
    //                                                 {({active}) => (
    //                                                     <a
    //                                                         href={'as;odkas;ldk;ad'}
    //                                                         className={classNames(
    //                                                             active ? 'bg-primary-100' : '',
    //                                                             'block py-2 px-4 text-sm text-primary-700'
    //                                                         )}
    //                                                     >
    //                                                         sldjasldjsalkdjalkd
    //                                                     </a>
    //                                                 )}
    //                                         </Menu.Item>
    //                                     </Menu.Items>
    //                                 </Transition>
    //                             </Menu>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>
    //
    //             <Disclosure.Panel className="lg:hidden">
    //                 <div className="px-2 pt-2 pb-3 space-y-1">
    //                     {/*{navigation.map((item) => (*/}
    //                     {/*    <Disclosure.Button*/}
    //                     {/*        key={item.name}*/}
    //                     {/*        as="a"*/}
    //                     {/*        href={item.href}*/}
    //                     {/*        className={classNames(*/}
    //                     {/*            item.current*/}
    //                     {/*                ? 'bg-primary-700 text-white'*/}
    //                     {/*                : 'text-white hover:bg-primary-500 hover:bg-opacity-75',*/}
    //                     {/*            'block rounded-md py-2 px-3 text-base font-medium'*/}
    //                     {/*        )}*/}
    //                     {/*        aria-current={item.current ? 'page' : undefined}*/}
    //                     {/*    >*/}
    //                     {/*        {item.name}*/}
    //                     {/*    </Disclosure.Button>*/}
    //                     {/*))}*/}
    //                 </div>
    //                 <div className="pt-4 pb-3 border-t border-primary-700">
    //                     <div className="px-5 flex items-center">
    //                         <div className="ml-3">
    //                             <div className="text-base font-medium text-white">{auth.user.name}</div>
    //                             <div className="text-sm font-medium text-primary-300">{auth.user.email}</div>
    //                         </div>
    //                     </div>
    //                     <div className="mt-3 px-2 space-y-1">
    //                         {/*{userNavigation.map((item) => (*/}
    //                         {/*    <Disclosure.Button*/}
    //                         {/*        key={item.name}*/}
    //                         {/*        as="a"*/}
    //                         {/*        href={item.href}*/}
    //                         {/*        className="block rounded-md py-2 px-3 text-base font-medium text-white hover:bg-primary-500 hover:bg-opacity-75"*/}
    //                         {/*    >*/}
    //                         {/*        {item.name}*/}
    //                         {/*    </Disclosure.Button>*/}
    //                         {/*))}*/}
    //                     </div>
    //                 </div>
    //             </Disclosure.Panel>
    //         </>
    //     )}
    // </Disclosure>
    //
    // const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);
    //
    // return <nav className="bg-primary-600 border-b border-primary-300 border-opacity-25 lg:border-none">
    //     <div className="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
    //         <div
    //             className="relative h-16 flex items-center justify-between lg:border-b lg:border-primary-400 lg:border-opacity-25">
    //             <div className="px-2 flex items-center lg:px-0">
    //                 <div className="shrink-0 flex items-center">
    //                     <Link href="/">
    //                         <ApplicationLogo className="block h-9 w-auto text-primary-500"/>
    //                     </Link>
    //                 </div>
    //
    //                 <div className="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    //                     <div className="flex space-x-4">
    //                         <NavLink href={route('feed.index')} active={route().current('feed.index')}>
    //                             Your Feeds
    //                         </NavLink>
    //                     </div>
    //                 </div>
    //             </div>
    //
    //             <div className="hidden sm:flex sm:items-center sm:ml-6">
    //                 <div className="ml-3 relative">
    //                     <Dropdown>
    //                         <Dropdown.Trigger>
    //                             <span className="inline-flex rounded-md">
    //                                 <button
    //                                     type="button"
    //                                     className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-primary-500 bg-white hover:text-primary-700 focus:outline-none transition ease-in-out duration-150"
    //                                 >
    //                                     {auth.user.name}
    //
    //                                     <svg
    //                                         className="ml-2 -mr-0.5 h-4 w-4"
    //                                         xmlns="http://www.w3.org/2000/svg"
    //                                         viewBox="0 0 20 20"
    //                                         fill="currentColor"
    //                                     >
    //                                         <path
    //                                             fillRule="evenodd"
    //                                             d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
    //                                             clipRule="evenodd"
    //                                         />
    //                                     </svg>
    //                                 </button>
    //                             </span>
    //                         </Dropdown.Trigger>
    //
    //                         <Dropdown.Content>
    //                             <Dropdown.Link href={route('logout')} method="post" as="button">
    //                                 Log Out
    //                             </Dropdown.Link>
    //                         </Dropdown.Content>
    //                     </Dropdown>
    //                 </div>
    //             </div>
    //
    //             <div className="-mr-2 flex items-center sm:hidden">
    //                 <button
    //                     onClick={() => setShowingNavigationDropdown((previousState) => !previousState)}
    //                     className="inline-flex items-center justify-center p-2 rounded-md text-primary-400 hover:text-primary-500 hover:bg-primary-100 focus:outline-none focus:bg-primary-100 focus:text-primary-500 transition duration-150 ease-in-out"
    //                 >
    //                     <svg className="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
    //                         <path
    //                             className={!showingNavigationDropdown ? 'inline-flex' : 'hidden'}
    //                             strokeLinecap="round"
    //                             strokeLinejoin="round"
    //                             strokeWidth="2"
    //                             d="M4 6h16M4 12h16M4 18h16"
    //                         />
    //                         <path
    //                             className={showingNavigationDropdown ? 'inline-flex' : 'hidden'}
    //                             strokeLinecap="round"
    //                             strokeLinejoin="round"
    //                             strokeWidth="2"
    //                             d="M6 18L18 6M6 6l12 12"
    //                         />
    //                     </svg>
    //                 </button>
    //             </div>
    //         </div>
    //     </div>
    //
    //     <div className={(showingNavigationDropdown ? 'block' : 'hidden') + ' sm:hidden'}>
    //         <div className="pt-2 pb-3 space-y-1">
    //             <ResponsiveNavLink href={route('dashboard')} active={route().current('feed.index')}>
    //                 Your feeds
    //             </ResponsiveNavLink>
    //         </div>
    //
    //         <div className="pt-4 pb-1 border-t border-primary-200">
    //             <div className="px-4">
    //                 <div className="font-medium text-base text-white">{auth.user.name}</div>
    //                 <div className="font-medium text-sm text-primary-300">{auth.user.email}</div>
    //             </div>
    //
    //             <div className="mt-3 space-y-1">
    //                 <ResponsiveNavLink method="post" href={route('logout')} as="button">
    //                     Log Out
    //                 </ResponsiveNavLink>
    //             </div>
    //         </div>
    //     </div>
    // </nav>
}
