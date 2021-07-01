import React from "react";

const Next = props => {
  const { onClick = () => {} } = props;
  return (
    <div className="next">
      <button onClick={onClick}>&#10095;</button>
    </div>
  );
};
export default Next;