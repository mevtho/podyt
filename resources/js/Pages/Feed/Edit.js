import React from "react";
import {Head, Link} from "@inertiajs/inertia-react";
import Authenticated from "@/Layouts/Authenticated";
import {ExclamationIcon, PencilIcon} from "@heroicons/react/outline";
import FeedForm from "@/Pages/Feed/FeedForm";
import Section from "@/Components/Section";

export default function Edit({feed}) {
    return <Authenticated
        header={"Edit " + feed.title}
    >
        <Head title={feed.title}/>

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
                              className="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm"
                        >
                            Delete Feed
                        </Link>
                    </div>
                </div>
            </Section>
        </div>
    </Authenticated>
}
