import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';

// Import Bootstrap CSS
import 'bootstrap/dist/css/bootstrap.min.css';

// Import des composants React
import NavigationTabs from './components/NavigationTabs';
import DashboardStats from './components/DashboardStats';
import RecentLists from './components/RecentLists';

// Montage des composants React
document.addEventListener('DOMContentLoaded', () => {
    // Navigation Tabs (Option D)
    const navTabsEl = document.getElementById('navigation-tabs');
    if (navTabsEl) {
        const root = createRoot(navTabsEl);
        root.render(<NavigationTabs />);
    }

    // Dashboard Stats (Option A)
    const statsEl = document.getElementById('dashboard-stats');
    if (statsEl) {
        const statsData = JSON.parse(statsEl.dataset.stats || '{}');
        const root = createRoot(statsEl);
        root.render(<DashboardStats initialData={statsData} />);
    }

    // Recent Lists (Option B)
    const listsEl = document.getElementById('recent-lists');
    if (listsEl) {
        const root = createRoot(listsEl);
        root.render(<RecentLists />);
    }
});