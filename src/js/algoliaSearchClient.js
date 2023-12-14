import algoliasearch from "algoliasearch/lite";

const algoliaClient = algoliasearch(
  process.env.MIX_ALGOLIA_SEARCH_APPLICATION_ID,
  process.env.MIX_ALGOLIA_SEARCH_API_KEY
);

const iniated = false;

const searchClient = {
  ...algoliaClient,
  search(requests) {
    if (
      iniated &&
      requests.every(({ params }) => !params.query || params.query <= 2)
    ) {
      return Promise.resolve({
        results: requests.map(() => ({
          hits: [],
          nbHits: 0,
          nbPages: 0,
          page: 0,
          processingTimeMS: 0,
        })),
      });
    }

    this.iniated = true;

    return algoliaClient.search(requests);
  },
};

export default searchClient;
