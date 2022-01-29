import React, {useEffect, useState} from "react";
import {Head, Link, useForm} from "@inertiajs/inertia-react";
import Authenticated from "@/Layouts/Authenticated";
import {Inertia} from "@inertiajs/inertia";
import {PlusCircleIcon, PlusIcon, TrashIcon} from "@heroicons/react/outline";

export default function Create({}) {
    const {data, setData, post, progress} = useForm({
        title: "",
        cover_photo: null,
        sources: []
    })

    console.log(data);

    function handleSubmitCreateFeed(e) {
        e.preventDefault();

        post(route('feed.store'), data);
    }

    function addNewSource() {
        setData('sources', [...data.sources, '']);
    }

    function removeSource(sourceIdx) {
        setData('sources', data.sources.filter((s, idx) => idx !== sourceIdx));
    }

    return <Authenticated
        header="New Feed"
    >
        <Head title="New Feed"/>

        <form onSubmit={handleSubmitCreateFeed}
              className="max-w-3xl space-y-8 divide-y divide-primary-200">
            <div>
                <div>
                    <h3 className="text-lg leading-6 font-medium text-primary-900">
                        Details
                    </h3>
                </div>
                <div className="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div className="sm:col-span-6">
                        <label htmlFor="title" className="block text-sm font-medium text-primary-700">
                            Name
                        </label>
                        <div className="mt-1">
                            <input type="text"
                                   value={data.title} onChange={e => setData('title', e.target.value)}
                                   className="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-primary-300 rounded-md" />
                        </div>
                        {/*<x-input-error name="title"/>*/}
                    </div>
                    <div className="sm:col-span-6">
                        <label htmlFor="cover_photo" className="block text-sm font-medium text-primary-700">
                            Cover Photo
                        </label>
                        <div className="mt-1 flex items-center">
                        <span className="h-32 w-32 overflow-hidden bg-primary-100">
                            <img src="/img/default-cover.png" alt="cover"/>
                        </span>
                            <input type="file"
                                   accept=".png,.jpg,.jpeg,.gif"
                                   onChange={e => setData('cover_photo', e.target.files[0])}
                                   className="ml-5 bg-white py-2 px-3 border border-primary-300 rounded-md shadow-sm text-sm leading-4 font-medium text-primary-700 hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"/>
                        </div>
                    </div>
                    <div className="sm:col-span-6">
                        <label htmlFor="sources" className="block text-sm font-medium text-primary-700">
                            Youtube Playlist Sources
                        </label>
                        <div className="mt-1">
                            <ul id="sources">
                                {data.sources.map((source, idx) => (
                                    <li className="mb-2" key={idx}>
                                        <div className="mt-1 flex rounded-md shadow-sm">
                                            <div className="relative flex items-stretch flex-grow focus-within:z-10">
                                                <input
                                                    type="text"
                                                    value={source}
                                                    placeholder="https://www.youtube.com/playlist?list=<list_identifier>"
                                                    onChange={e => setData('sources', data.sources.map((s, aSourceidx) => aSourceidx === idx ? e.target.value : s))}
                                                    className="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-none rounded-l-md sm:text-sm border-primary-300"
                                                />
                                            </div>
                                            <button
                                                type="button"
                                                onClick={() => removeSource(idx)}
                                                className="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-primary-300 text-sm font-medium rounded-r-md text-primary-700 bg-primary-50 hover:bg-primary-100 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500"
                                            >
                                                <TrashIcon className="h-5 w-5 text-primary-400" aria-hidden="true" />
                                                <span>Remove</span>
                                            </button>
                                        </div>
                                    </li>
                                ))
                                }
                            </ul>
                        </div>
                        <div>
                            <button type="button"
                                    onClick={addNewSource}
                                    className="group inline-flex items-center text-sm font-medium rounded text-primary-700 hover:underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                            >
                                <PlusCircleIcon
                                    className="h-6 w-6 group-hover:text-white group-hover:bg-primary-700 rounded-full"/>
                                Add Source
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {progress && (
                <progress value={progress.percentage} max="100">
                    {progress.percentage}%
                </progress>
            )}
            <div className="pt-5">
                <div className="flex justify-end">
                    <Link href={route('feed.index')}
                          className="bg-white py-2 px-4 border border-primary-300 rounded-md shadow-sm text-sm font-medium text-primary-700 hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Cancel
                    </Link>
                    <button type="submit"
                            className="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </Authenticated>
}
