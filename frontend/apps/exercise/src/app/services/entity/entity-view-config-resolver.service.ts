import {ActivatedRouteSnapshot} from "@angular/router";
import {EntityViewMode} from "../../model/entity-component/entity-view-mode";
import {Injectable} from "@angular/core";
import {EntityViewConfig} from "../../model/entity-component/entity-view-config";
import {EntityType} from "../../model/entity-component/entity-type";

@Injectable()
export class EntityViewConfigResolverService {
  public resolveViewConfig(routeSnapshot: ActivatedRouteSnapshot): EntityViewConfig {
    const type: EntityType = routeSnapshot.params['type'];
    const id: string | undefined = routeSnapshot.params['id'];
    const mode: EntityViewMode = this.getViewMode(routeSnapshot, id);

    return { mode, type, id };
  }

  public getViewMode(routeSnapshot: ActivatedRouteSnapshot, id?: string): EntityViewMode {
    const lastPathSegment: string = routeSnapshot.url[routeSnapshot.url.length - 1].path;

    if (id) {
      return lastPathSegment === 'edit' ? EntityViewMode.form : EntityViewMode.full;
    }

    return lastPathSegment === 'add' ? EntityViewMode.form : EntityViewMode.list;
  }
}
