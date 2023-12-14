import configs from "./configs";

export const fade = (element, customConfigs = {}) => {
  const config = {
    ...configs.fade,
    ...customConfigs
  };

  const animation = [{ opacity: 0 }, { opacity: 1 }];

  return new KeyframeEffect(element, animation, config.timings);
};

export const move = (element, customConfigs = {}) => {
  const config = {
    ...configs.move,
    ...customConfigs
  };

  element.style.transformOrigin = config.transformOrigin;

  const animation = [
    { transform: `translate${config.axis}(0)` },
    { transform: `translate${config.axis}(${config.offset}px)` }
  ];

  return new KeyframeEffect(element, animation, config.timings);
};

export const scale = (element, customConfigs = {}) => {
  const config = {
    ...configs.scale,
    ...customConfigs
  };

  element.style.transformOrigin = config.transformOrigin;

  const animation = [
    { transform: `scale${config.axis}(0)` },
    { transform: `scale${config.axis}(1)` }
  ];

  return new KeyframeEffect(element, animation, config.timings);
};

export const slide = (element, customConfigs = {}) => {
  const config = {
    ...configs.slide,
    ...customConfigs
  };

  element.style.opacity = 0;

  const animation = [
    { transform: `translate${config.axis}(${config.offset})`, opacity: 0 },
    { transform: "translateX(0)", opacity: 1 }
  ];

  return new KeyframeEffect(element, animation, config.timings);
};

export const rotate = (element, customConfigs = {}) => {
  const config = {
    ...configs.rotate,
    ...customConfigs
  };

  const animation = [
    { transform: `rotate${config.axis}(0)` },
    { transform: `rotate${config.axis}(${config.angle})` }
  ];

  return new KeyframeEffect(element, animation, config.timings);
};

export default {
  fade,
  rotate,
  move,
  slide,
  scale
};
