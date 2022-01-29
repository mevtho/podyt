import React from "react";
import {Head} from "@inertiajs/inertia-react";
import Authenticated from "@/Layouts/Authenticated";
import {PlusIcon} from "@heroicons/react/outline";
import FeedForm from "@/Pages/Feed/FeedForm";
import Section from "@/Components/Section";

export default function Create() {
    return <Authenticated
        header="New Feed"
    >
        <Head title="New Feed"/>

        <div
            className="max-w-3xl">
            <Section
                icon={<PlusIcon className="h-6 w-6 text-primary-600" aria-hidden="true"/>}
                iconBackground="bg-primary-100"
                label="Create Feed"
            >
                <div className="mt-2">
                    <FeedForm />
                </div>
            </Section>
        </div>
    </Authenticated>
}
