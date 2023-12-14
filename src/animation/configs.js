import { mediumTimings } from "./timings";

export const base = {
  timings: mediumTimings,
  transformOrigin: "center center"
};

export default {
  move: {
    ...base,
    // axis: 'X', 'Y'
    axis: "Y",
    offset: 100
  },
  scale: {
    ...base,
    // axis: 'X', 'Y'
    axis: "X"
  },
  fade: {
    ...base
  },
  slide: {
    ...base,
    // axis: 'X', 'Y'
    axis: "X",
    offset: "-20vh"
  },
  rotate: {
    ...base,
    // axis: '', 'X', 'Y', 'Z'
    axis: "",
    angle: "180deg"
  }
};
