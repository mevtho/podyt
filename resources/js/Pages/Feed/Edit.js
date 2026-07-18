import React from "react";
import {Head, Link} from "@inertiajs/inertia-react";
import Authenticated from "@/Layouts/Authenticated";
import {ExclamationIcon, PencilIcon, RefreshIcon} from "@heroicons/react/outline";
import FeedForm from "@/Pages/Feed/FeedForm";
import Section from "@/Components/Section";

export default function Edit({feed}) {
    const sourcesWithErrors = feed.sources.filter(source => source.error_count > 0);

    return <Authenticated
        header={feed.title}
    >
        <Head title={feed.title} />

        <div
            className="max-w-3xl">
            <Section
                icon={<PencilIcon className="h-6 w-6 text-primary-600" aria-hidden="true"/>}
                iconBackground="bg-primary-100"
                label="Edit Feed"
            >
                <div className="mt-2">
                <FeedForm
                    feed={feed}
                />
                </div>
            </Section>
        </div>

        {sourcesWithErrors.length > 0 &&
            <>
                <hr className="my-8"/>

                <div
                    className="max-w-3xl">
                    <Section
                        icon={<ExclamationIcon className="h-6 w-6 text-yellow-600" aria-hidden="true"/>}
                        iconBackground="bg-yellow-100"
                        label="Source Errors"
                    >
                        <p className="text-sm text-gray-500">
                            These sources have stopped updating after repeated errors. Reset a source to let it be
                            checked again.
                        </p>
                        <ul className="mt-4 divide-y divide-primary-200">
                            {sourcesWithErrors.map(source => (
                                <li key={source.id} className="py-3 flex items-center justify-between">
                                    <div>
                                        <p className="text-sm font-medium text-primary-900">
                                            {source.name || source.sourceUrl}
                                        </p>
                                        <p className="text-sm text-red-600">
                                            {source.error_count} consecutive errors
                                        </p>
                                    </div>
                                    <Link
                                        as="button"
                                        type="button"
                                        method="post"
                                        href={route("feed.source.reset-error-count", {feed, source})}
                                        preserveScroll
                                        preserveState
                                        only={["feed"]}
                                        className="inline-flex items-center gap-1 py-2 px-3 border border-primary-300 rounded-md shadow-sm text-sm font-medium text-primary-700 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                    >
                                        <RefreshIcon className="h-4 w-4"/>
                                        Reset
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </Section>
                </div>
            </>
        }

        <hr className="my-8"/>

        <div
            className="max-w-3xl">
            <Section
                icon={<ExclamationIcon className="h-6 w-6 text-red-600" aria-hidden="true"/>}
                iconBackground="bg-red-100"
                label="Delete Feed"
            >
                <p className="text-sm text-gray-500">
                    Are you sure you want to delete this feed your account? All data will be permanently
                    removed. This action cannot be undone.
                </p>
                <div className="pt-5">
                    <div className="flex justify-end">
                        <Link method="DELETE"
                              href={route("feed.destroy", {feed})}
                              as="button"
                              className="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm"
                        >
                            Delete Feed
                        </Link>
                    </div>
                </div>
            </Section>
        </div>
    </Authenticated>
}
