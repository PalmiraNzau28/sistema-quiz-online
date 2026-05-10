import { TestBed } from '@angular/core/testing';

import { ExternalApi } from './external-api';

describe('ExternalApi', () => {
  let service: ExternalApi;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ExternalApi);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
