import {Entity} from "./entity";
import {EntityType} from "../entity-component/entity-type";

export interface Permission extends Entity {
  type: EntityType.permission,
  name: string,
}
