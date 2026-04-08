import React from 'react';

export default function DashboardStats({ initialData }) {
    return (
        <div className="dashboard-stats">
            {/* TODO: Add Dashboard Stats component */}
            <p>Dashboard Stats Placeholder</p>
            <pre>{JSON.stringify(initialData, null, 2)}</pre>
        </div>
    );
}
