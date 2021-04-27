import {Injectable} from "@angular/core";
import {HttpClient, HttpResponse} from "@angular/common/http";
import {Observable} from "rxjs";
import {Entity} from "../../model/entity/entity";
import {EntityType} from "../../model/entity-component/entity-type";
import {FormGroup} from "@angular/forms";
import {response} from "express";
import {map} from "rxjs/operators";

@Injectable()
export class EntityClientService {
  private pathApi: string = '/api/entity'

  public constructor(private httpClient: HttpClient) {
  }

  public find(type: EntityType): Observable<Entity[]> {
    return this.httpClient.get<Entity[]>(this.formatEntityTypePath(type));
  }

  public load(type: EntityType, id: string | number): Observable<Entity> {
    return this.httpClient.get<Entity>(this.formatEntityPath(type, id));
  }

  public delete(type: EntityType, id: string | number): Observable<unknown> {
    return this.httpClient.delete(this.formatEntityPath(type, id));
  }

  public update(type: EntityType, id: string | number, form: FormGroup): Observable<unknown> {
    return this.httpClient.patch(this.formatEntityPath(type, id), form.value);
  }

  public create(type: EntityType, form: FormGroup): Observable<string> {
    return this.httpClient
      .post(this.formatEntityTypePath(type), form.value, {observe: 'response'})
      .pipe(
        map(
          (response: HttpResponse<unknown>): string => response.headers.get('Location')!
        )
      );
  }

  private formatEntityTypePath(type: EntityType): string {
    return `${this.pathApi}/${type}`;
  }

  private formatEntityPath(type: EntityType, id: string | number): string {
    return `${this.pathApi}/${type}/${id}`;
  }
}
