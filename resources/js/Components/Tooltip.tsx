import React from 'react';

const Tooltip = ({ children, x, y, visible }) => {
  if (!visible) return null;
  return (
    <div style={{
      position: 'absolute',
      top: y,
      left: x,
      transform: 'translate(-50%, -100%)',
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
