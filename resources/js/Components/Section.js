import React from "react";

export default function Section({icon, iconBackground, label, children}) {
    return <div className="sm:flex sm:items-start">
        <div
            className={iconBackground + " mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10"}>
            {icon}
        </div>
        <div className="flex-1 mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 className="text-lg leading-6 font-medium text-primary-900">
                {label}
            </h3>
            <div className="mt-2">
                {children}
            </div>
        </div>
    </div>
}
