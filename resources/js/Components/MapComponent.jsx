import React, { useState, useRef } from 'react';
import JamaicaMap from '../assets/jamMap.svg?react';
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

const towers = [
    { id: 'OLT Negril', top: '34%', left: '19%' },
    { id: 'OLT Mandeville', top: '57%', left: '42%' },
    { id: 'OLT St. Anns Bay', top: '29%', left: '52%' },
    { id: 'OLT Independence City', top: '68%', left: '59%' },
    { id: 'OLT Old Harbour', top: '65%', left: '56%' },
    { id: 'OLT St. Jago', top: '59%', left: '60%' },
    { id: 'OLT Dumfries', top: '58%', left: '66%' },
    { id: 'OLT Barbican', top: '57%', left: '69%' },
    { id: 'OLT Bridgeport', top: '64%', left: '62%' },
];

const MapComponent = ({ title, onTowerClick }) => {
    const [activeTower, setActiveTower] = useState(null);
    const [tooltip, setTooltip] = useState({ visible: false, x: 0, y: 0, text: '' });
    const containerRef = useRef(null);

    const handleTowerClick = (towerId) => {
        if (activeTower === towerId) {
            setActiveTower(null);
        } else {
            setActiveTower(towerId);
        }
        onTowerClick(towerId);
    };

    const handleMouseOver = (e, towerId) => {
        const containerRect = containerRef.current.getBoundingClientRect();
        setTooltip({
            visible: true,
            x: e.clientX - containerRect.left,
            y: e.clientY - (containerRect.top + 10),
            text: towerId,
        });
    };

    const handleMouseOut = () => {
        setTooltip({ visible: false, x: 0, y: 0, text: '' });
    };

    return (
        <Card className="bg-[var(--foreground)] pb-6">
            <CardHeader className="px-7">
                <CardTitle className="text-white">{title}</CardTitle>
                <CardDescription>Click on the towers to view more details.</CardDescription>
            </CardHeader>
            <CardContent className="relative" ref={containerRef}>
                <div style={{ width: '100%', height: 'auto', marginBottom: '10px' }} className="overflow-hidden">
                    <JamaicaMap style={{ width: '100%', height: 'auto' }} />
                    {towers.map((tower) => (
                        <OLTTower
                            key={tower.id}
                            id={tower.id}
                            onClick={() => handleTowerClick(tower.id)}
                            onMouseOver={(e) => handleMouseOver(e, tower.id)}
                            onMouseOut={handleMouseOut}
                            style={{
                                position: 'absolute',
                                top: tower.top,
                                left: tower.left,
                                width: '28px',
                                height: '28px',
                                fill: activeTower === tower.id ? 'red' : 'white',
                                cursor: 'pointer'
                            }}
                        />
                    ))}
                </div>
                <Tooltip visible={tooltip.visible} x={tooltip.x} y={tooltip.y}>
                    {tooltip.text}
                </Tooltip>
            </CardContent>
            <CardFooter className="flex flex-col items-center text-sm">
                <div className="flex gap-2 font-medium leading-none text-white">
                    OLT Distribution across Jamaica
                </div>
            </CardFooter>
        </Card>
    );
};

export default MapComponent;
