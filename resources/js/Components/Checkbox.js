import React from 'react';

export default function Checkbox({ name, value, handleChange }) {
    return (
        <input
            type="checkbox"
            name={name}
            value={value}
            className="rounded border-primary-300 text-secondary-600 shadow-sm focus:border-secondary-300 focus:ring focus:ring-secondary-200 focus:ring-opacity-50"
            onChange={(e) => handleChange(e)}
        />
    );
}
