import React from 'react';

const Tooltip = ({ children, x, y, visible }) => {
  if (!visible) return null;
  return (
    <div style={{
      position: 'fixed',
      top: y - 10, // Adjusted to position it slightly above the mouse pointer
      left: x + 10, // Adjusted to position it slightly to the right of the mouse pointer
      backgroundColor: 'rgba(0, 0, 0, 0.8)',
      color: 'white',
      padding: '5px 10px',
      borderRadius: '4px',
      pointerEvents: 'none',
      whiteSpace: 'nowrap',
      zIndex: 1000,
    }}>
      {children}
    </div>
  );
};

export default Tooltip;
