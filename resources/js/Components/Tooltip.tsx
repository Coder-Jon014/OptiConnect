import React from 'react';
import '@/assets/Map.css';

const Tooltip = ({ children, x, y, visible }) => {
  if (!visible) return null;
  return (
    <div className="tooltip" style={{ top: y, left: x }}>
      {children}
    </div>
  );
};

export default React.memo(Tooltip);
