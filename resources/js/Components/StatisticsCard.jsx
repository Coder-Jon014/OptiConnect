import React from 'react';

const StatisticsCard = ({ title, value }) => {
    return (
        <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 className="text-lg font-medium text-gray-900 dark:text-gray-200">{title}</h3>
            <p className="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-200">{value}</p>
        </div>
    );
};

export default StatisticsCard;
