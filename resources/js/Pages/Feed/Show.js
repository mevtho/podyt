import React, {useEffect, useState} from "react";
import {Head, Link} from "@inertiajs/inertia-react";
import Authenticated from "@/Layouts/Authenticated";
import {CalendarIcon, CogIcon} from "@heroicons/react/outline";
import {format, parseISO} from "date-fns";
import {Inertia} from "@inertiajs/inertia";
import classNames from "@/Helpers/classNames";

export default function Show({feed}) {
    const [newEpisodeUrl, setNewEpisodeUrl] = useState("");

    const statusToRefreshRate = {
        pending: 15,
        processing: 30,
        default: (feed.sources?.length > 0) ? 30 : 120
    }

    useEffect(() => {
        const interval = (feed.episodes || []).reduce(
            (c, episode) => Math.min(c, statusToRefreshRate[episode.status] || statusToRefreshRate.default),
            statusToRefreshRate.default
        );

        const timeoutId = setTimeout(() => {
            Inertia.get(route("feed.show", {feed}), {}, {preserveScroll: true});
        }, interval * 1000);

        return () => clearTimeout(timeoutId)
    }, [feed]);

    function handleSubmitAddEpisode(e) {
        e.preventDefault();

        Inertia.post(route("feed.episode.store", {feed}), {source_url: newEpisodeUrl});

        setNewEpisodeUrl("");
    }

    function renderSources() {
        if (feed.sources?.length === 0) {
            return null;
        }

        return <div>
            <span className="font-bold">Following playlists : </span>
            <ul>
                {feed.sources.map(source => <li key={source.feed_id}>{source.name}</li>)}
            </ul>
        </div>

    }

    return <Authenticated
        header={feed.title}
    >
        <Head title={feed.title}/>

        <div className="flex flex-col space-y-4">
            <div>
                <div className="sm:flex">
                    <div className="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4">
                        <img
                            src={feed.coverUrl}
                            alt={feed.title + " cover"}
                            className="mx-auto h-48 w-48 border border-primary-300 bg-white text-primary-300"/>
                    </div>
                    <div className="flex flex-col w-full">
                        <div className="flex-grow flex justify-between">
                            <p>
                                {feed.description}
                            </p>
                            <p className="flex-shrink-0">
                                <Link className="text-secondary-500 hover:opacity-75 focus:opacity-75"
                                      href={route("feed.edit", {feed})}>
                                    <CogIcon className="w-8 h-8"/>
                                </Link>
                            </p>
                        </div>
                        {renderSources()}
                        <div className="mt-6 max-w-xl">
                            <label htmlFor="feed_url" className="block text-sm font-medium text-primary-700">
                                Feed URL
                            </label>
                            <div className="mt-1 flex rounded-md shadow-sm">
                                <a
                                    href={feed.rssUrl}
                                    target="_blank"
                                    className="inline-flex items-center px-3 rounded-l-md border border-r-0 border-primary-300 bg-primary-50 text-secondary-500 sm:text-sm hover:bg-primary-100 focus:bg-primary-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                              d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                    </svg>
                                </a>
                                <input type="text" name="feed_url" id="feed_url"
                                       className="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-primary-500 focus:border-primary-500 sm:text-sm border-primary-300"
                                       value={feed.rssUrl} readOnly/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div className="pb-5 border-b border-primary-200 sm:flex sm:items-center sm:justify-between">
                    <h3 className="text-lg leading-6 font-bold text-primary-900">
                        Episodes
                    </h3>
                    <div className="mt-3 flex sm:mt-0 sm:ml-4">
                        <form onSubmit={handleSubmitAddEpisode} className="w-full">
                            <label htmlFor="source_url" className="sr-only">Youtube Video URL</label>
                            <div className="mt-1 flex rounded-md shadow-sm">
                                <div className="relative flex items-stretch flex-grow focus-within:z-10">
                                    <input type="url" name="source_url" id="source_url"
                                           onChange={(e) => setNewEpisodeUrl(e.target.value)}
                                           value={newEpisodeUrl}
                                           className="focus:ring-primary-400 focus:border-primary-400 block w-full rounded-none rounded-l-md sm:text-sm border-primary-300"
                                           placeholder="Youtube video URL"/>
                                </div>
                                <button type="submit"
                                        className="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-primary-300 text-sm font-medium rounded-r-md text-primary-700 bg-primary-50 hover:bg-primary-100 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                                    <span>Add Episode</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                {
                    (feed.episodes.length === 0) &&
                    <div className="text-center p-2">
                        <h3 className="mt-2 text-sm font-medium text-primary-900">No episode</h3>
                        <p className="mt-1 text-sm text-primary-500">
                            Get started by importing a new video from youtube.
                        </p>
                    </div>
                }
                {
                    (feed.episodes.length > 0) &&
                    <ul role="list" className="divide-y divide-primary-200 border-primary-200">
                        {feed.episodes.map(episode => (
                            <li key={episode.id} className="flex items-center py-2 sm:px-6">
                                <div className="h-16 w-32 text-center flex-shrink-0">
                                    <img src={episode.picture_url} className="h-full" alt="youtube thumbnail"/>
                                </div>
                                <div className="flex-grow flex-shrink">
                                    <div className="flex items-center justify-between">
                                        <p className="text-sm font-medium text-primary-600 truncate">
                                            {episode.title}
                                        </p>
                                        <div className="ml-2 flex-shrink-0 flex">
                                            <p
                                                className={classNames(
                                                    episode.status === "published" ? "bg-green-100 text-green-800" : "",
                                                    episode.status === "failed" ? "bg-red-100 text-red-800" : "",
                                                    ["published", "failed"].indexOf(episode.status) === -1 ? "bg-primary-100 text-primary-800" : "",
                                                    "px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                )}
                                            >
                                                {episode.status}
                                            </p>
                                        </div>
                                    </div>
                                    <div className="mt-2 flex justify-between">
                                        <div className="flex gap-1">
                                            <a href={episode.source_url}
                                                  title="Youtube Source Video"
                                                  target="_blank">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                                    className="flex-shrink-0 mr-1.5 h-5 w-5 text-red-500">
                                                    <path fill="currentColor"
                                                          d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/>
                                                </svg>
                                                <span className="sr-only">Source</span>
                                            </a>

                                            {episode.download_url &&
                                                <a href={episode.download_url}
                                                   className="text-secondary-500 hover:opacity-75 focus:opacity-75"
                                                   title="MP3 File Download">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24"
                                                         strokeWidth="2" stroke="currentColor"
                                                         className="flex-shrink-0 mr-1.5 h-5 w-5"
                                                    >
                                                        <path strokeLinecap="round" strokeLinejoin="round"
                                                              d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                                                    </svg>
                                                    <span className="sr-only">Download</span>
                                                </a>
                                            }
                                        </div>
                                        <div className="mt-2 flex items-center text-sm text-primary-500 sm:mt-0">
                                            <CalendarIcon className="flex-shrink-0 mr-1.5 h-5 w-5 text-primary-400"/>
                                            <p>
                                                <span className="mr-1">Added</span>
                                                <time
                                                    dateTime={format(parseISO(episode.created_at), "MMM do")}>
                                                    {format(parseISO(episode.created_at), "MMM do")}
                                                </time>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        ))}
                    </ul>
                }
            </div>
        </div>
    </Authenticated>
}
