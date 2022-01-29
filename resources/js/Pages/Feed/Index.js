import React from "react";
import {Head, Link} from "@inertiajs/inertia-react";
import Authenticated from "@/Layouts/Authenticated";
import {PlusCircleIcon} from "@heroicons/react/outline";

export default function Index({feeds}) {
    return <Authenticated
        header="Your Feeds"
    >
        <Head title="Your Feeds"/>

        <div className="p-6">
            <ul role="list" className="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                {feeds.map(feed => (
                    <li className="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-primary-200" key={feed.slug}>
                        <Link href={route('feed.show', {feed})}
                              className="h-full bg-right-600 hover:bg-secondary-100">
                            <div className="flex-1 flex flex-col p-8">
                                <img className="w-32 h-32 flex-shrink-0 mx-auto"
                                     src={feed.coverUrl}
                                     alt={feed.title + ' cover'}/>
                                <h3 className="mt-6 text-primary-900 text-sm font-medium">
                                    {feed.title}
                                </h3>
                                <dl className="mt-1 flex-grow flex flex-col justify-between">
                                    <dt className="sr-only">Number of episodes</dt>
                                    <dd className="text-primary-500 text-sm">{feed.episodes_count} episodes</dd>
                                </dl>
                            </div>
                        </Link>
                    </li>
                ))}
                <li className="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-primary-200">
                    <Link href={route('feed.create')}
                       className="h-full bg-right-600 hover:bg-secondary-100 text-secondary-100 hover:text-white">
                        <div className="flex-1 flex flex-col p-8">
                            <PlusCircleIcon className="w-32 h-32 flex-shrink-0 mx-auto" />
                            <h3 className="mt-6 text-primary-900 text-sm font-medium">
                                Add Feed
                            </h3>
                            <dl className="mt-1 flex-grow flex flex-col justify-between">
                                <dt className="sr-only" />
                                <dd className="text-primary-500 text-sm" />
                            </dl>
                        </div>
                    </Link>
                </li>
            </ul>
        </div>
    </Authenticated>
}
//
//
//     <x-app-layout>
        // <x-slot name="header">
        // Your Feeds
        // </x-slot>
        //
        // <div className="p-6">
        // <ul role="list" className="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        // @foreach($feeds as $feed)
        // <li className="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-primary-200">
        // <a href="{{ route('feed.show', ['feed' => $feed]) }"
        //                    className="h-full bg-right-600 hover:bg-secondary-100">
        //                     <div className="flex-1 flex flex-col p-8">
        //                         <img className="w-32 h-32 flex-shrink-0 mx-auto"
        //                              src="{{ $feed->coverUrl() }"
        //                              alt="{{ $feed->title } cover">
        //                             <h3 className="mt-6 text-primary-900 text-sm font-medium">
        //                                 {feed.title}
        //                             </h3>
        //                             <dl className="mt-1 flex-grow flex flex-col justify-between">
        //                                 <dt className="sr-only">Number of episodes</dt>
        //                                 <dd className="text-primary-500 text-sm">{feed.episodes_count} episodes</dd>
        //                             </dl>
        //                     </div>
        //                 </a>
        //             </li>
        //             @endforeach
        //             <li className="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-primary-200">
        //                 <a href="{{ route('feed.create') }"
        //                    className="h-full bg-right-600 hover:bg-secondary-100 text-secondary-100 hover:text-white">
        //                     <div className="flex-1 flex flex-col p-8">
        //                         <svg xmlns="http://www.w3.org/2000/svg" className="w-32 h-32 flex-shrink-0 mx-auto" fill="none"
        //                              viewBox="0 0 24 24" stroke="currentColor">
        //                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        //                                   d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
        //                         </svg>
        //                         <h3 className="mt-6 text-primary-900 text-sm font-medium">
        //                             {{__('Add Feed')}
        //                         </h3>
        //                         <dl className="mt-1 flex-grow flex flex-col justify-between">
        //                             <dt className="sr-only"></dt>
        //                             <dd className="text-primary-500 text-sm"></dd>
        //                         </dl>
        //                     </div>
        //                 </a>
        //             </li>
        //         </ul>
        //     </div>
        // </x-app-layout>
        // }
