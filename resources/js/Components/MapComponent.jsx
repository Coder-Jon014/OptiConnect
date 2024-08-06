import React, { useState, useRef, useCallback, useMemo } from 'react';
import JamaicaMap from '../assets/jamMap.optimized.svg?react';
import OLTTower from '../assets/oltTower.svg?react';
import Tooltip from './Tooltip';  // Adjust the import path as necessary
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
    CardDescription,
    CardFooter,
} from "@/Components/ui/card";
import '@/assets/Map.css';

const towers = [
    { id: 'OLT Negril', top: '34%', left: '14%' },
    { id: 'OLT Mandeville', top: '57%', left: '42%' },
    { id: 'OLT St. Anns Bay', top: '29%', left: '52%' },
    { id: 'OLT Independence City', top: '68%', left: '59%' },
    { id: 'OLT Old Harbour', top: '65%', left: '56%' },
    { id: 'OLT St. Jago', top: '59%', left: '60%' },
    { id: 'OLT Dumfries', top: '58%', left: '66%' },
    { id: 'OLT Barbican', top: '57%', left: '69%' },
    { id: 'OLT Bridgeport', top: '64%', left: '62%' },
];

const MapComponent = React.memo(({ title, onTowerClick, ongoingOutages }) => {
    const [activeTower, setActiveTower] = useState(null);
    const tooltipRef = useRef(null);
    const containerRef = useRef(null);

    const handleTowerClick = useCallback((towerId) => {
        setActiveTower(prevTower => prevTower === towerId ? null : towerId);
        onTowerClick(towerId);
    }, [onTowerClick]);

    const handleMouseOver = useCallback((e, towerId) => {
        const containerRect = containerRef.current.getBoundingClientRect();
        tooltipRef.current.style.left = `${e.clientX - containerRect.left}px`;
        tooltipRef.current.style.top = `${e.clientY - containerRect.top + 10}px`;
        tooltipRef.current.innerText = towerId;
        tooltipRef.current.style.display = 'block';
    }, []);

    const handleMouseOut = useCallback(() => {
        tooltipRef.current.style.display = 'none';
    }, []);

    const memoizedTowers = useMemo(() => towers.map(tower => {
        const isOngoingOutage = ongoingOutages.some(outage => outage.olt.olt_name === tower.id);
        return (
            <OLTTower
                key={tower.id}
                id={tower.id}
                onClick={() => handleTowerClick(tower.id)}
                onMouseOver={(e) => handleMouseOver(e, tower.id)}
                onMouseOut={handleMouseOut}
                className={`tower ${tower.id}`}
                style={{
                    position: 'absolute',
                    top: tower.top,
                    left: tower.left,
                    fill: isOngoingOutage ? 'red' : 'white',
                    cursor: 'pointer'
                }}
            />
        );
    }), [handleTowerClick, handleMouseOver, handleMouseOut, ongoingOutages]);

    return (
        <Card className="bg-[var(--foreground)] pb-6">
            <CardHeader className="px-7">
                <CardTitle className="text-white">{title}</CardTitle>
                <CardDescription>Click on the towers to view more details.</CardDescription>
            </CardHeader>
            <CardContent className="relative" ref={containerRef}>
                <div style={{ width: '100%', height: 'auto', marginBottom: '10px' }} className="overflow-hidden">
                    <JamaicaMap style={{ width: '100%', height: 'auto' }} />
                    {memoizedTowers}
                </div>
                <Tooltip ref={tooltipRef} />
            </CardContent>
            <CardFooter className="flex flex-col items-center text-sm">
                <div className="flex gap-2 font-medium leading-none text-white">
                    OLT Distribution across Jamaica
                </div>
            </CardFooter>
        </Card>
    );
});

export default MapComponent;
