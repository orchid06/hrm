(function () {
  ("use strict");

  // Device Width
  const deviceWidth = window.innerWidth;

  window.addEventListener("load", () => {
    // Timeline initialization
    var tl = gsap.timeline();

    // Check if the banner section exists before proceeding
    const bannerSection = document.querySelector(".banner");
    if (bannerSection) {
      const tlSplitGreat = gsap.timeline({
          onComplete: () => {
            SplitGreat.revert();
          },
        }),
        SplitGreat = new SplitText(".quote-title", {
          type: "words,chars",
        }),
        chars = SplitGreat.chars;

      tlSplitGreat.from(
        chars,
        {
          duration: 0.8,
          opacity: 0,
          ease: "circ.out",
          stagger: 0.02,
        },
        "+=0"
      );
    }

    // Section Title
    const quotes = document.querySelectorAll(".title-anim");
    if (quotes) {
      function setupSplits() {
        quotes.forEach((quote) => {
          // Reset if needed
          if (quote.anim) {
            quote.anim.progress(1).kill();
            quote.split.revert();
          }

          quote.split = new SplitText(quote, {
            type: "lines,words,chars",
            linesClass: "split-line",
          });

          // Set up the anim
          quote.anim = gsap.from(quote.split.chars, {
            scrollTrigger: {
              trigger: quote,
              start: "top 70%",
              end: "bottom center",
              // scrub: 1,
            },
            duration: 0.6,
            ease: "circ.out",
            opacity: 0,
            stagger: 0.02,
          });
        });
      }
      ScrollTrigger.addEventListener("refresh", setupSplits);
      setupSplits();
    }

    // Card Batch Animation
    function batch(targets, vars) {
      let varsCopy = {},
        interval = vars.interval || 0.2,
        proxyCallback = (type, callback) => {
          let batch = [],
            delay = gsap
              .delayedCall(interval, () => {
                callback(batch);
                batch.length = 0;
              })
              .pause();
          return (self) => {
            batch.length || delay.restart(true);
            batch.push(self.trigger);
            vars.batchMax && vars.batchMax <= batch.length && delay.progress(2);
          };
        },
        p;
      for (p in vars) {
        varsCopy[p] =
          ~p.indexOf("Enter") || ~p.indexOf("Leave")
            ? proxyCallback(p, vars[p])
            : vars[p];
      }
      gsap.utils.toArray(targets).forEach((target) => {
        let config = {};
        for (p in varsCopy) {
          config[p] = varsCopy[p];
        }
        config.trigger = target;
        ScrollTrigger.create(config);
      });
    }

    batch(".fade-item", {
      interval: 0.1,
      batchMax: 4,
      onEnter: (batch) =>
        gsap.to(batch, {
          autoAlpha: 1,
          duration: 0.3,
          stagger: 0.5,
          overwrite: true,
        }),
      onLeave: (batch) =>
        gsap.set(batch, {
          autoAlpha: 1,
          overwrite: true,
        }),
    });

    // Reveal animations based on scroll
    function animateFrom(elem, direction) {
      direction = direction || 1;
      var x = 0,
        y = direction * 100;
      if (elem.classList.contains("fromLeft")) {
        x = -100;
        y = 0;
      } else if (elem.classList.contains("fromRight")) {
        x = 100;
        y = 0;
      }

      elem.style.transform = `translate(${x}px, ${y}px)`;
      elem.style.opacity = "0";

      gsap.fromTo(
        elem,
        { x: x, y: y, autoAlpha: 0 },
        {
          duration: 1,
          x: 0,
          y: 0,
          autoAlpha: 1,
          ease: "expo.easeOut",
          overwrite: "auto",
        }
      );
    }

    function hide(elem) {
      gsap.set(elem, { autoAlpha: 0 });
    }

    gsap.utils.toArray(".gs_reveal").forEach((elem) => {
      hide(elem);
      ScrollTrigger.create({
        trigger: elem,
        onEnter: () => animateFrom(elem),
        onEnterBack: () => animateFrom(elem, -1),
        onLeave: () => hide(elem),
      });
    });
  });
})();
