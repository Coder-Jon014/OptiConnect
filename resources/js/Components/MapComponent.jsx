import React from 'react';
import JamaicaMap from '../assets/jamMap.svg?react';
import OLTTower from '../assets/oltTower.svg?react';

const MapComponent = () => {
    return (
      <div style={{ position: 'relative', width: '100%', height: 'auto' }}>
        <JamaicaMap style={{ width: '100%', height: 'auto' }} />
        <OLTTower id=" OLT Negril" style={{
          position: 'absolute',
          top: '37%', // Adjust based on where you want to place the tower
          left: '16%', // Adjust based on where you want to place the tower
          width: '30px', // Adjust size as needed
          height: '30px', // Adjust size as needed
          fill: 'white'
        }} />
        <OLTTower id=" OLT Mandeville" style={{
            position: 'absolute',
            top: '59%', // Adjust based on where you want to place the tower
            left: '40%', // Adjust based on where you want to place the tower
            width: '30px', // Adjust size as needed
            height: '30px', // Adjust size as needed
            fill: 'white'
            }} />
        <OLTTower id="OLT St. Anns Bay" style={{
            position: 'absolute',
            top: '30%', // Adjust based on where you want to place the tower
            left: '50%', // Adjust based on where you want to place the tower
            width: '30px', // Adjust size as needed
            height: '30px', // Adjust size as needed
            fill: 'white'
            }} />
        <OLTTower id="OLT Independence City" style={{
            position: 'absolute',
            top: '70%', // Adjust based on where you want to place the tower
            left: '30%', // Adjust based on where you want to place the tower
            width: '30px', // Adjust size as needed
            height: '30px', // Adjust size as needed
            fill: 'white'
            }} />
        <OLTTower id="OLT Old Harbour" style={{
            position: 'absolute',
            top: '80%', // Adjust based on where you want to place the tower
            left: '80%', // Adjust based on where you want to place the tower
            width: '30px', // Adjust size as needed
            height: '30px', // Adjust size as needed
            fill: 'white'
            }} />
        <OLTTower id="OLT St. Jago" style={{
            position: 'absolute',
            top: '90%', // Adjust based on where you want to place the tower
            left: '10%', // Adjust based on where you want to place the tower
            width: '30px', // Adjust size as needed
            height: '30px', // Adjust size as needed
            fill: 'white'
            }} />
        <OLTTower id="OLT Dumfries" style={{
            position: 'absolute',
            top: '80%', // Adjust based on where you want to place the tower
            left: '40%', // Adjust based on where you want to place the tower
            width: '30px', // Adjust size as needed
            height: '30px', // Adjust size as needed
            fill: 'white'
            }} />
        <OLTTower id="OLT Barbican" style={{
            position: 'absolute',
            top: '70%', // Adjust based on where you want to place the tower
            left: '90%', // Adjust based on where you want to place the tower
            width: '30px', // Adjust size as needed
            height: '30px', // Adjust size as needed
            fill: 'white'
            }} />
        <OLTTower id="OLT Bridgeport" style={{
            position: 'absolute',
            top: '60%', // Adjust based on where you want to place the tower
            left: '10%', // Adjust based on where you want to place the tower
            width: '30px', // Adjust size as needed
            height: '30px', // Adjust size as needed
            fill: 'white'
            }} />
      </div>
    );
  };
  
  export default MapComponent;