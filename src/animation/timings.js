import eases from "./eases";

const baseProps = {
  iterations: 1,
  easing: "ease-out",
  fill: "forwards"
};

export const fastestTimings = {
  ...baseProps,
  duration: 300
};

export const fastTimings = {
  ...baseProps,
  duration: 500
};

export const mediumTimings = {
  ...baseProps,
  duration: 700
};

export const staggerTimings = index => {
  return {
    ...baseProps,
    delay: index * 100,
    duration: 400,
    easing: eases.squeezyOut
  };
};
