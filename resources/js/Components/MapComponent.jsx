import React, { useState } from 'react';
import JamaicaMap from '../assets/jamMap.svg?react';
import OLTTower from '../assets/oltTower.svg?react';

const towers = [
    {id: 'OLT Negril', top: '42%', left: '19%'},
    {id: 'OLT Mandeville', top: '59%', left: '40%'},
    {id: 'OLT St. Anns Bay', top: '40%', left: '50%'},
    {id: 'OLT Independence City', top: '72%', left: '59%'},
    {id: 'OLT Old Harbour', top: '68%', left: '56%'},
    {id: 'OLT St. Jago', top: '62%', left: '60%'},
    {id: 'OLT Dumfries', top: '64%', left: '66%'},
    {id: 'OLT Barbican', top: '63%', left: '69%'},
    {id: 'OLT Bridgeport', top: '68%', left: '62%'},
];

const MapComponent = ({ title, onTowerClick }) => {
    const [activeTower, setActiveTower] = useState(null);

    const handleTowerClick = (towerId) => {
        if (activeTower === towerId) {
            setActiveTower(null);
        } else {
            setActiveTower(towerId);
        }
        onTowerClick(towerId);
    };

    return (
        <div style={{ position: 'relative', width: '100%', height: 'auto', marginBottom:'10px' }} className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 className="text-lg font-medium text-gray-900 dark:text-gray-200">{title}</h3>
            <JamaicaMap style={{ width: '100%', height: 'auto' }} />
            {towers.map((tower) => (
                <OLTTower key={tower.id} id={tower.id} onClick={() => handleTowerClick(tower.id)} style={{
                    position: 'absolute',
                    top: tower.top,
                    left: tower.left,
                    width: '25px',
                    height: '25px',
                    fill: activeTower === tower.id ? 'red' : 'white',
                    cursor: 'pointer'
                }} />
            ))}
        </div>
    );
};

export default MapComponent;
